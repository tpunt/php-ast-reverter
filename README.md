# php-ast-reverter
A package reverts an abstract syntax tree (AST) produced by the php-ast
extenion back into (somewhat) PSR-compliant code. This enables for code
pre-processing to be done.

Requirements:
 - PHP 7
 - [php-ast](https://github.com/nikic/php-ast) extension (it should be
 compatible with both versions 10 and 20)

Example:
```php
<?php

$code = <<<'end'
<?php

/**
 * My testing class
 */
class ClassName extends AnotherClass implements AnInterface
{
    /**
     * Some property
     */
    private $prop = 0;

    const TEST = 'string';

    use TraitA, TraitB {
        TraitA::func1 insteadof TraitB;
        TraitB::func1 as protected func2;
    }

    /**
     * Some useless constructor
     */
    function __construct(int $arg = 1)
    {
        $this->prop = $arg;
    }
}
end;

$ast = ast\parse_code($code);

echo (new AstReverter\AstReverter)->getCode($ast);
```

Output:
```php
<?php

/**
 * My testing class
 */
class ClassName extends AnotherClass implements AnInterface
{
    /**
     * Some property
     */
    private $prop = 0;
    const TEST = "string";
    use TraitA, TraitB {
        TraitA::func1 insteadof TraitB;
        TraitB::func1 as protected func2;
    }
    /**
     * Some useless constructor
     */
    public function __construct(int $arg = 1)
    {
        $this->prop = $arg;
    }
}

```