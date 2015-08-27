<?php

namespace AstReverter;

use ast\Node;

class AstReverter
{
    private $indentationLevel = 0;

    const INDENTATION_CHAR = ' ';
    const INDENTATION_SIZE = 4;

    public function __construct()
    {
        //
    }

    private function revertAST($node) : string
    {
        if (!$node instanceof Node) {
            switch (gettype($node)) {
                case 'integer':
                case 'double':
                case 'boolean':
                    return $node;
                case 'string':
                    return "'{$node}'";
                default:
                    // an array should never come through here
                    assert(false, 'Unknown type found: ' . gettype($node));
            }
        }

        switch ($node->kind) {
            case \ast\AST_AND:
                return $this->and($node);
            case \ast\AST_ARG_LIST:
                return $this->argList($node);
            case \ast\AST_ARRAY:
                return $this->array($node);
            case \ast\AST_ASSIGN:
                return $this->assign($node);
            case \ast\AST_ASSIGN_OP:
                return $this->assignOp($node);
            case \ast\AST_BINARY_OP:
                return $this->binaryOp($node);
            case \ast\AST_BREAK:
                return $this->break($node);
            case \ast\AST_CALL:
                return $this->call($node);
            case \ast\AST_CLASS:
                return $this->class($node);
            case \ast\AST_CLASS_CONST:
                return $this->classConst($node);
            case \ast\AST_COALESCE:
                return $this->coalesce($node);
            case \ast\AST_CONDITIONAL:
                return $this->conditional($node);
            case \ast\AST_CONST:
                return $this->const($node);
            case \ast\AST_DIM:
                return $this->dim($node);
            case \ast\AST_ECHO:
                return $this->echo($node);
            case \ast\AST_ENCAPS_LIST:
                return $this->encapsList($node);
            case \ast\AST_EXIT:
                return $this->exit($node);
            case \ast\AST_FUNC_DECL:
                return $this->funcDecl($node);
            case \ast\AST_HALT_COMPILER:
                return $this->haltCompiler($node);
            case \ast\AST_IF:
                return $this->if($node);
            case \ast\AST_IF_ELEM:
                return $this->ifElem($node);
            case \ast\AST_MAGIC_CONST:
                return $this->magicConst($node);
            case \ast\AST_METHOD:
                return $this->method($node); // @update
            case \ast\AST_METHOD_CALL:
                return $this->methodCall($node);
            case \ast\AST_NAME:
                return $this->name($node);
            case \ast\AST_NAMESPACE:
                return $this->decomposeNamespace($node); // @update
            case \ast\AST_NAME_LIST:
                return $this->nameList($node);
            case \ast\AST_OR:
                return $this->or($node);
            case \ast\AST_PARAM:
                return $this->param($node);
            case \ast\AST_PARAM_LIST:
                return $this->paramList($node);
            case \ast\AST_PRINT:
                return $this->print($node);
            case \ast\AST_PROP:
                return $this->prop($node);
            case \ast\AST_PROP_DECL:
                return $this->propDecl($node);
            case \ast\AST_PROP_ELEM:
                return $this->propElem($node);
            case \ast\AST_RETURN:
                return $this->return($node);
            case \ast\AST_STATIC_CALL:
                return $this->staticCall($node);
            case \ast\AST_STATIC_PROP:
                return $this->staticProp($node);
            case \ast\AST_STMT_LIST:
                return $this->stmtList($node);
            case \ast\AST_SWITCH:
                return $this->switch($node);
            case \ast\AST_SWITCH_CASE:
                return $this->switchCase($node);
            case \ast\AST_SWITCH_LIST:
                return $this->switchList($node);
            case \ast\AST_TYPE:
                return $this->type($node);
            case \ast\AST_UNARY_MINUS:
                return $this->unaryMinus($node);
            case \ast\AST_UNARY_PLUS:
                return $this->unaryPlus($node);
            case \ast\AST_UNPACK:
                return $this->unpack($node);
            case \ast\AST_VAR:
                return $this->var($node);
            default:
                // for development mode only
                var_dump(\ast\get_kind_name($node->kind));
                return '';
        }
    }

    /**
     * Custom method not node-related to encapsulate common logic of
     * methodCall() and staticCall() methods.
     */
    private function abstractCall(Node $node, string $op) : string
    {
        return $this->revertAST($node->children[0])
            . $op
            . ($node->children[1] instanceof Node
                ? $this->revertAST($node->children[1])
                : $node->children[1])
            . $this->revertAST($node->children[2]);
    }

    /**
     * Custom method not node-related to encapsulate common logic of
     * prop() and staticProp() methods.
     */
    private function abstractProp(Node $node, string $op) : string
    {
        $openBrace = '';
        $closeBrace = '';

        // Maintain the right associativity
        if (isset($node->children[1]->kind) && $node->children[1]->kind !== \ast\AST_VAR) {
            $openBrace = '{';
            $closeBrace = '}';
        }

        return $this->revertAST($node->children[0])
            . $op
            . $openBrace
            . ($node->children[1] instanceof Node
                ? $this->revertAST($node->children[1])
                : $node->children[1])
            . $closeBrace;
    }

    private function and(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' && '
            . $this->revertAST($node->children[1]);
    }

    private function argList(Node $node) : string
    {
        $args = [];

        foreach ($node->children as $child) {
            $args[] = $this->revertAST($child);
        }

        return '(' . implode(', ', $args) . ')';
    }

    private function array(Node $node) : string
    {
        return '[]';
    }

    private function assign(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' = '
            . $this->revertAST($node->children[1])
            . ';';
    }

    private function assignOp(Node $node) : string
    {
        $op = '';

        switch ($node->flags) {
            case \ast\flags\ASSIGN_BITWISE_OR:
                $op = '|=';
                break;
            case \ast\flags\ASSIGN_BITWISE_AND:
                $op = '&=';
                break;
            case \ast\flags\ASSIGN_BITWISE_XOR:
                $op = '^=';
                break;
            case \ast\flags\ASSIGN_CONCAT:
                $op = '.=';
                break;
            case \ast\flags\ASSIGN_ADD:
                $op = '+=';
                break;
            case \ast\flags\ASSIGN_SUB:
                $op = '-=';
                break;
            case \ast\flags\ASSIGN_MUL:
                $op = '*=';
                break;
            case \ast\flags\ASSIGN_DIV:
                $op = '/=';
                break;
            case \ast\flags\ASSIGN_MOD:
                $op = '%=';
                break;
            case \ast\flags\ASSIGN_POW:
                $op = '**=';
                break;
            case \ast\flags\ASSIGN_SHIFT_LEFT:
                $op = '>>=';
                break;
            case \ast\flags\ASSIGN_SHIFT_RIGHT:
                $op = '<<=';
                break;
            default:
                assert(false, "Flag not found: {$node->flags}");
        }

        return $this->revertAST($node->children[0])
            . " {$op} "
            . $this->revertAST($node->children[1])
            . ';';
    }

    private function binaryOp(Node $node) : string
    {
        $op = '';

        switch ($node->flags) {
            case \ast\flags\BINARY_BITWISE_OR:
                $op = '|';
                break;
            case \ast\flags\BINARY_BITWISE_AND:
                $op = '&';
                break;
            case \ast\flags\BINARY_BITWISE_XOR:
                $op = '^';
                break;
            case \ast\flags\BINARY_CONCAT:
                $op = '.';
                break;
            case \ast\flags\BINARY_ADD:
                $op = '+';
                break;
            case \ast\flags\BINARY_SUB:
                $op = '-';
                break;
            case \ast\flags\BINARY_MUL:
                $op = '*';
                break;
            case \ast\flags\BINARY_DIV:
                $op = '/';
                break;
            case \ast\flags\BINARY_MOD:
                $op = '%';
                break;
            case \ast\flags\BINARY_POW:
                $op = '**';
                break;
            case \ast\flags\BINARY_SHIFT_LEFT:
                $op = '<<';
                break;
            case \ast\flags\BINARY_SHIFT_RIGHT:
                $op = '>>';
                break;
            case \ast\flags\BINARY_BOOL_XOR:
                $op = 'XOR';
                break;
            case \ast\flags\BINARY_IS_IDENTICAL:
                $op = '===';
                break;
            case \ast\flags\BINARY_IS_NOT_IDENTICAL:
                $op = '!==';
                break;
            case \ast\flags\BINARY_IS_EQUAL:
                $op = '==';
                break;
            case \ast\flags\BINARY_IS_NOT_EQUAL:
                $op = '!=';
                break;
            case \ast\flags\BINARY_IS_SMALLER:
                $op = '<';
                break;
            case \ast\flags\BINARY_IS_SMALLER_OR_EQUAL:
                $op = '<=';
                break;
            case \ast\flags\BINARY_IS_GREATER:
                $op = '>';
                break;
            case \ast\flags\BINARY_IS_GREATER_OR_EQUAL:
                $op = '>=';
                break;
            case \ast\flags\BINARY_SPACESHIP:
                $op = '<=>';
                break;
            default:
                assert(false, "Node not found: {\ast\get_kind_name($node->kind)}");
        }

        return $this->revertAST($node->children[0])
            . " {$op} "
            . $this->revertAST($node->children[1]);
    }

    private function break(Node $node) : string
    {
        return 'break';
    }

    private function call(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . $this->revertAST($node->children[1]);
    }

    private function class(Node $node) : string
    {
        $modifier = '';
        $type = 'class';
        $extends = '';
        $implements = '';

        switch ($node->flags) {
            case \ast\flags\CLASS_ABSTRACT:
                $modifier = 'abstract ';
                break;
            case \ast\flags\CLASS_FINAL:
                $modifier = 'final ';
                break;
            case \ast\flags\CLASS_TRAIT:
                $type = 'trait';
                break;
            case \ast\flags\CLASS_INTERFACE:
                $type = 'interface';
        }

        if ($node->children[0] !== null) {
            $extends .= " extends {$this->revertAST($node->children[0])}";
        }

        if ($node->children[1] !== null) {
            $implements .= " implements {$this->revertAST($node->children[1])}";
        }

        $code = "{$modifier}{$type} {$node->name}{$extends}{$implements}"
            . PHP_EOL
            . $this->indent()
            . '{'
            . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[2]);

        --$this->indentationLevel;

        return $code . $this->indent() . '}';
    }

    private function classConst(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . '::'
            . ($node->children[1] instanceof Node
                ? $this->revertAST($node->children[1])
                : $node->children[1]);
    }

    private function coalesce(Node $node) : string
    {
        return '('
            . $this->revertAST($node->children[0])
            . ' ?? '
            . $this->revertAST($node->children[1])
            . ')';
    }

    private function conditional(Node $node) : string
    {
        return '('
            . $this->revertAST($node->children[0])
            . ' ? '
            . $this->revertAST($node->children[1])
            . ' : '
            . $this->revertAST($node->children[2])
            . ')';
    }

    private function const(Node $node) : string
    {
        return $this->revertAST($node->children[0]);
    }

    private function dim(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . '['
            . $this->revertAST($node->children[1])
            . ']';
    }

    private function echo(Node $node) : string
    {
        return "echo {$this->revertAST($node->children[0])}";
    }

    private function encapsList(Node $node) : string
    {
        $code = '"';

        foreach ($node->children as $child) {
            if ($child instanceof Node) {
                $code .= '{' . $this->revertAST($child) . '}';
            } else {
                $code .= $this->revertAST($child);
            }
        }

        $code .= '"';

        return $code;
    }

    private function exit(Node $node) : string
    {
        $code = 'die';

        if ($node->children[0] !== null) {
            $code .= "({$this->revertAST($node->children[0])})";
        }

        return $code;
    }

    /**
     * Custom method that terminates a statement irregardless.
     */
    private function forceTerminateStatement(string $buffer) : string
    {
        $lastChar = substr($buffer, -1);

        if ($lastChar === ';') {
            return PHP_EOL;
        }

        if ($lastChar === PHP_EOL) {
            return '';
        }

        return ';' . PHP_EOL;
    }

    private function funcDecl(Node $node) : string
    {
        $code = '';
        $returnType = '';

        if (isset($node->docComment)) {
            $code .= $node->docComment . PHP_EOL;
        }

        if ($node->children[3] !== null) {
            $returnType .= " : {$this->revertAST($node->children[3])}";
        }

        $code .= $this->indent()
            . "function {$node->name}"
            . $this->revertAST($node->children[0])
            . $returnType
            . PHP_EOL
            . $this->indent()
            . '{'
            . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[2]);

        --$this->indentationLevel;

        $code .= $this->indent() . '}' . PHP_EOL;

        return $code;
    }

    public function getCode(Node $node)
    {
        return $this->revertAST($node) . PHP_EOL;
    }

    private function haltCompiler(Node $node) : string
    {
        return '__halt_compiler()';
    }

    private function if(Node $node) : string
    {
        $code = '';
        $childCount = count($node->children);

        for ($i = 0; $i < $childCount; ++$i) {
            if ($childCount !== 1 && $i === $childCount -1) {
                $code .= ' else';
            } else {
                if ($i === 0) {
                    $code .= 'if ';
                } else {
                    $code .= ' elseif ';
                }

                $code .= $this->revertAST($node->children[$i]);
            }

            $code .= ' {' . PHP_EOL;

            ++$this->indentationLevel;

            $code .= $this->revertAST($node->children[$i]->children[1]);

            --$this->indentationLevel;

            $code .= $this->indent() . '}';
        }

        return $code;
    }

    private function ifElem(Node $node) : string
    {
        // @TODO AST_IF_ELEM 2 children - not sure what 2nd child is for
        return '('
            . $this->revertAST($node->children[0])
            . ')';
    }

    private function indent() : string
    {
        return str_repeat(
            self::INDENTATION_CHAR,
            $this->indentationLevel * self::INDENTATION_SIZE
        );
    }

    private function magicConst(Node $node)
    {
        // ignore for now
    }

    private function method(Node $node) : string
    {
        $code = '';
        $scope = '';

        if (isset($node->docComment)) {
            $code .= $node->docComment . PHP_EOL . $this->indent();
        }

        // (abstract|final)?(public|protected|private)(static)?
        switch ($node->flags) {
            case \ast\flags\MODIFIER_PUBLIC:
                $scope = 'public';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PUBLIC:
                $scope = 'abstract public';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PUBLIC:
                $scope = 'final public';
                break;
            case \ast\flags\MODIFIER_PUBLIC | \ast\flags\MODIFIER_STATIC:
                $scope = 'public static';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PUBLIC | \ast\flags\MODIFIER_STATIC:
                $scope = 'abstract public static';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PUBLIC | \ast\flags\MODIFIER_STATIC:
                $scope = 'final public static';
                break;
            case \ast\flags\MODIFIER_PROTECTED:
                $scope = 'protected';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PROTECTED:
                $scope = 'abstract protected';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PROTECTED:
                $scope = 'final protected';
                break;
            case \ast\flags\MODIFIER_PROTECTED | \ast\flags\MODIFIER_STATIC:
                $scope = 'protected static';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PROTECTED | \ast\flags\MODIFIER_STATIC:
                $scope = 'abstract protected static';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PROTECTED | \ast\flags\MODIFIER_STATIC:
                $scope = 'final protected static';
                break;
            case \ast\flags\MODIFIER_PRIVATE:
                $scope = 'private';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PRIVATE:
                $scope = 'abstract private';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PRIVATE:
                $scope = 'final private';
                break;
            case \ast\flags\MODIFIER_PRIVATE | \ast\flags\MODIFIER_STATIC:
                $scope = 'private static';
                break;
            case \ast\flags\MODIFIER_ABSTRACT | \ast\flags\MODIFIER_PRIVATE | \ast\flags\MODIFIER_STATIC:
                $scope = 'abstract private static';
                break;
            case \ast\flags\MODIFIER_FINAL | \ast\flags\MODIFIER_PRIVATE | \ast\flags\MODIFIER_STATIC:
                $scope = 'final private static';
                break;
            default:
                assert(false, 'Unknown flag combination: ' . $node->flags);
        }

        $code .= "{$scope} function {$node->name}{$this->revertAST($node->children[0])}";

        if ($node->children[3] !== null) {
            $code .= " : {$this->revertAST($node->children[3])}";
        }

        $code .= PHP_EOL
            . $this->indent()
            . '{'
            . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[2]);

        --$this->indentationLevel;

        $code .= $this->indent()
            . '}'
            . PHP_EOL;

        return $code;
    }

    private function methodCall(Node $node) : string
    {
        return $this->abstractCall($node, '->');
    }

    private function name(Node $node) : string
    {
        return $node->children[0];
    }

    private function nameList(Node $node) : string
    {
        $interfaces = [];

        foreach ($node->children as $child) {
            $interfaces[] = $child->children[0];
        }

        return implode(', ', $interfaces);
    }

    private function or(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' || '
            . $this->revertAST($node->children[1]);
    }

    private function param(Node $node) : string
    {
        $code = '';
        $modifier = '';

        switch ($node->flags) {
            case \ast\flags\PARAM_VARIADIC:
                $modifier = '...';
                break;
            case \ast\flags\PARAM_REF:
                $modifier = '&';
        }

        if ($node->children[0] !== null) {
            $code .= "{$this->revertAST($node->children[0])} ";
        }

        $code .= "{$modifier}\${$node->children[1]}";

        if ($node->children[2] !== null) {
            $code .= " = {$this->revertAST($node->children[2])}";
        }

        return $code;
    }

    private function paramList(Node $node) : string
    {
        $params = [];

        foreach ($node->children as $child) {
            $params[] = $this->revertAST($child);
        }

        return '(' . implode(', ', $params) . ')';
    }

    private function print(Node $node) : string
    {
        $code = 'print ';

        if ($node->children[0] instanceof Node) {
            $code .= $this->revertAST($node->children[0]);
        } else {
            $code .= "{$this->revertAST($node->children[0])}";
        }

        return $code;
    }

    private function prop(Node $node) : string
    {
        return $this->abstractProp($node, '->');
    }

    private function propDecl(Node $node) : string
    {
        $code = '';
        $scope = '';

        if (isset($node->docComment)) {
            $code .= $node->docComment . PHP_EOL . $this->indent();
        }

        // (public|protected|private)(static)?
        switch ($node->flags) {
            case \ast\flags\MODIFIER_PUBLIC:
                $scope = 'public';
                break;
            case \ast\flags\MODIFIER_PUBLIC | \ast\flags\MODIFIER_STATIC:
                $scope = 'public static';
                break;
            case \ast\flags\MODIFIER_PROTECTED:
                $scope = 'protected';
                break;
            case \ast\flags\MODIFIER_PROTECTED | \ast\flags\MODIFIER_STATIC:
                $scope = 'protected static';
                break;
            case \ast\flags\MODIFIER_PRIVATE:
                $scope = 'private';
                break;
            case \ast\flags\MODIFIER_PRIVATE | \ast\flags\MODIFIER_STATIC:
                $scope = 'private static';
                break;
            default:
                assert(false, 'Unknown flag combination: ' . $node->flags);
        }

        return "{$code}{$scope} {$this->revertAST($node->children[0])}";
    }

    private function propElem(Node $node) : string
    {
        $default = '';

        if ($node->children[1] !== null) {
            $default .= " = {$this->revertAST($node->children[1])}";
        }

        return "\${$node->children[0]}{$default}";
    }

    private function return(Node $node) : string
    {
        return "return {$this->revertAST($node->children[0])};";
    }

    private function staticCall(Node $node) : string
    {
        return $this->abstractCall($node, '::');
    }

    private function staticProp(Node $node) : string
    {
        return $this->abstractProp($node, '::$');
    }

    private function stmtList(Node $node) : string
    {if ($node === null)var_dump($node);
        $code = '';

        foreach ($node->children as $child) {
            if ($child instanceof Node && $child->kind !== \ast\AST_STMT_LIST) {
                $code .= $this->indent();
            }

            $code .= $this->revertAST($child);

            if (
                $child instanceof Node
                && (
                    $child->kind === \ast\AST_VAR
                    || $child->kind === \ast\AST_PROP
                    || $child->kind === \ast\AST_STATIC_PROP
                )
            ) {
                $code .= $this->forceTerminateStatement($code);
            } else {
                $code .= $this->terminateStatement($code);
            }
        }

        return $code;
    }

    private function switch(Node $node) : string
    {
        $code = "{$this->indent()}switch ({$this->revertAST($node->children[0])}) {" . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[1]);

        --$this->indentationLevel;

        return $code . "{$this->indent()}}";
    }

    private function switchCase(Node $node) : string
    {
        $code = $this->indent();

        if ($node->children[0] === null) {
            $code .= 'default:';
        } else {
            $code .= "case {$this->revertAST($node->children[0])}:";
        }

        $code .= PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[1]);

        --$this->indentationLevel;

        return $code;
    }

    private function switchList(Node $node) : string
    {
        $code = '';

        foreach ($node->children as $child) {
            $code .= $this->revertAST($child);
        }

        return $code;
    }

    /**
     * Custom method that ensures statements are terminated.
     */
    private function terminateStatement(string $buffer) : string
    {
        if ($buffer === '') {
            return '';
        }

        $lastChar = substr($buffer, -1);

        if ($lastChar !== '}') {
            return $this->forceTerminateStatement($buffer);
        }

        return PHP_EOL;
    }

    private function type(Node $node) : string
    {
        return 'array';
    }

    private function unaryMinus(Node $node) : string
    {
        return "-{$this->revertAST($node->children[0])}";
    }

    private function unaryPlus(Node $node) : string
    {
        return $this->revertAST($node->children[0]); // removes the unary plus
    }

    private function unpack(Node $node) : string
    {
        return "...{$this->revertAST($node->children[0])}";
    }

    private function var(Node $node) : string
    {
        $code = '$';

        if (!$node->children[0] instanceof Node) {
            return $code . $node->children[0];
        }

        return "{$code}{{$this->revertAST($node->children[0])}}";
    }
}
