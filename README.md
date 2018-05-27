# MeekFramework 'Collection' Component

Provides implementations and contracts for dealing with data structures.

The data type of the first element added to any collection implementation then becomes the only supported type for that collection instance.

Example using scalar types:

```php
$stack = new Meek\Collection\UnboundedStack();

$stack->push('1');  // All future push() operations will only accept the string data type.

$stack->push(2);    // Throws an InvalidArgumentException -> must be a string
```

Example using objects:

```php
class MyClass extends stdClass {}

$stack = new Meek\Collection\UnboundedStack();

$stack->push(new stdClass());   // All future push() operations will only accept instances of `stdClass`.
$stack->push(new MyClass());    // Works fine as `MyClass` is sub-classed from `stdClass`


$stack->push(new class {});    // Throws an InvalidArgumentException -> must be an instance of "stdClass"
```

## Usage

### Stack

Reversing a string using an `UnboundedStack`:

```php
$wordToReverse = 'dog';
$stack = new Meek\Collection\UnboundedStack(...str_split($wordToReverse));
$reversedWord = '';

while ($stack->size() > 0) {
    $reversedWord .= $stack->pop();
}

print $reversedWord;    // prints 'god'
```

Keeping track of history using a `BoundedStack`:

```php
$numberOfActionsToKeepTrackOf = 3;
$stack = new Meek\Collection\BoundedStack($numberOfActionsToKeepTrackOf);

$perform = function ($action) use ($stack) {
    $stack->push($action);
    echo sprintf('perform: %s', $action);
};

$undo = function () use ($stack) {
    $action = $stack->pop();
    echo sprintf('undo: %s', $action);
};

$perform('select all');     // prints 'perform: select all'
$perform('copy');           // prints 'perform: copy'
$perform('paste');          // prints 'perform: paste'
$undo();                    // prints 'undo: paste'
$perform('paste');          // prints 'perform: paste'

try {
    $perform('select all');
} catch (OverflowException $e) {
    // clear history and keep going or notify user that history is full
}
```
