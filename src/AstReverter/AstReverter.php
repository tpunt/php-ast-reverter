<?php

namespace AstReverter;

use ast\Node;

class AstReverter
{
    private $fromFile = true;
    private $indentationLevel = 0;

    const INDENTATION_CHAR = ' ';
    const INDENTATION_SIZE = 4;

    public function __construct($fromFile = true)
    {
        $this->fromFile = $fromFile;
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
                    return '"' . $this->sanitiseString($node) . '"';
                default:
                throw new \Exception;
                    // an array, null, etc, should never come through here
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
            case \ast\AST_ARRAY_ELEM:
                return $this->arrayElem($node);
            case \ast\AST_ASSIGN:
                return $this->assign($node);
            case \ast\AST_ASSIGN_OP:
                return $this->assignOp($node);
            case \ast\AST_ASSIGN_REF:
                return $this->assignRef($node);
            case \ast\AST_BINARY_OP:
                return $this->binaryOp($node);
            case \ast\AST_BREAK:
                return $this->break($node);
            case \ast\AST_CALL:
                return $this->call($node);
            case \ast\AST_CAST:
                return $this->cast($node);
            case \ast\AST_CATCH:
                return $this->catch($node);
            case \ast\AST_CATCH_LIST:
                return $this->catchList($node);
            case \ast\AST_CLASS:
                return $this->class($node);
            case \ast\AST_CLASS_CONST:
                return $this->classConst($node);
            case \ast\AST_CLASS_CONST_DECL:
                return $this->classConstDecl($node);
            case \ast\AST_CLONE:
                return $this->clone($node);
            case \ast\AST_CLOSURE:
                return $this->closure($node);
            case \ast\AST_CLOSURE_VAR:
                return $this->closureVar($node);
            case \ast\AST_COALESCE:
                return $this->coalesce($node);
            case \ast\AST_CONDITIONAL:
                return $this->conditional($node);
            case \ast\AST_CONST:
                return $this->const($node);
            case \ast\AST_CONST_DECL:
                return $this->constDecl($node);
            case \ast\AST_CONST_ELEM:
                return $this->constElem($node);
            case \ast\AST_CONTINUE:
                return $this->continue($node);
            case \ast\AST_DECLARE:
                return $this->declare($node);
            case \ast\AST_DIM:
                return $this->dim($node);
            case \ast\AST_DO_WHILE:
                return $this->doWhile($node);
            case \ast\AST_ECHO:
                return $this->echo($node);
            case \ast\AST_EMPTY:
                return $this->empty($node);
            case \ast\AST_ENCAPS_LIST:
                return $this->encapsList($node);
            case \ast\AST_EXIT:
                return $this->exit($node);
            case \ast\AST_EXPR_LIST:
                return $this->exprList($node);
            case \ast\AST_FOR:
                return $this->for($node);
            case \ast\AST_FOREACH:
                return $this->foreach($node);
            case \ast\AST_FUNC_DECL:
                return $this->funcDecl($node);
            case \ast\AST_GLOBAL:
                return $this->global($node);
            case \ast\AST_GOTO:
                return $this->goto($node);
            case \ast\AST_GREATER:
                return $this->greater($node);
            case \ast\AST_GREATER_EQUAL:
                return $this->greaterEqual($node);
            case \ast\AST_GROUP_USE:
                return $this->groupUse($node);
            case \ast\AST_HALT_COMPILER:
                return $this->haltCompiler($node);
            case \ast\AST_IF:
                return $this->if($node);
            case \ast\AST_IF_ELEM:
                return $this->ifElem($node);
            case \ast\AST_INCLUDE_OR_EVAL:
                return $this->includeOrEval($node);
            case \ast\AST_INSTANCEOF:
                return $this->instanceof($node);
            case \ast\AST_ISSET:
                return $this->isset($node);
            case \ast\AST_LABEL:
                return $this->label($node);
            case \ast\AST_LIST:
                return $this->list($node);
            case \ast\AST_MAGIC_CONST:
                return $this->magicConst($node);
            case \ast\AST_METHOD:
                return $this->method($node);
            case \ast\AST_METHOD_CALL:
                return $this->methodCall($node);
            case \ast\AST_METHOD_REFERENCE:
                return $this->methodReference($node);
            case \ast\AST_NAME:
                return $this->name($node);
            case \ast\AST_NAMESPACE:
                return $this->namespace($node);
            case \ast\AST_NAME_LIST:
                return $this->nameList($node);
            case \ast\AST_NEW:
                return $this->new($node);
            case \ast\AST_OR:
                return $this->or($node);
            case \ast\AST_PARAM:
                return $this->param($node);
            case \ast\AST_PARAM_LIST:
                return $this->paramList($node);
            case \ast\AST_POST_DEC:
                return $this->postDec($node);
            case \ast\AST_POST_INC:
                return $this->postInc($node);
            case \ast\AST_PRE_DEC:
                return $this->preDec($node);
            case \ast\AST_PRE_INC:
                return $this->preInc($node);
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
            case \ast\AST_SILENCE:
                return $this->silence($node);
            case \ast\AST_STATIC:
                return $this->static($node);
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
            case \ast\AST_THROW:
                return $this->throw($node);
            case \ast\AST_TRAIT_ADAPTATIONS:
                return $this->traitAdaptations($node);
            case \ast\AST_TRAIT_ALIAS:
                return $this->traitAlias($node);
            case \ast\AST_TRAIT_PRECEDENCE:
                return $this->traitPrecedence($node);
            case \ast\AST_TRY:
                return $this->try($node);
            case \ast\AST_TYPE:
                return $this->type($node);
            case \ast\AST_UNARY_MINUS:
                return $this->unaryMinus($node);
            case \ast\AST_UNARY_OP:
                return $this->unaryOp($node);
            case \ast\AST_UNARY_PLUS:
                return $this->unaryPlus($node);
            case \ast\AST_UNPACK:
                return $this->unpack($node);
            case \ast\AST_USE:
                return $this->use($node);
            case \ast\AST_USE_ELEM:
                return $this->useElem($node);
            case \ast\AST_USE_TRAIT:
                return $this->useTrait($node);
            case \ast\AST_VAR:
                return $this->var($node);
            case \ast\AST_WHILE:
                return $this->while($node);
            case \ast\AST_YIELD:
                return $this->yield($node);
            case \ast\AST_YIELD_FROM:
                return $this->yieldFrom($node);
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
        $code = '';

        if ($node->children[0]->kind === \ast\AST_NEW) {
            $code .= "({$this->revertAST($node->children[0])})";
        } else {
            $code .= $this->revertAST($node->children[0]);
        }

        $code .= $op
            . ($node->children[1] instanceof Node
                ? $this->revertAST($node->children[1])
                : $node->children[1])
            . $this->revertAST($node->children[2]);

        return $code;
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
        return '('
            . $this->commaSeparatedValues($node)
            . ')';
    }

    private function array(Node $node) : string
    {
        $code = '[';
        
        if (isset($node->children[0])) {
            $code .= $this->commaSeparatedValues($node);
        }

        return $code . ']';
    }

    private function arrayElem(Node $node) : string
    {
        $code = '';

        if ($node->children[1] === null) {
            $code .= $this->revertAST($node->children[0]);
        } else {
            $code .= "{$this->revertAST($node->children[1])} => {$this->revertAST($node->children[0])}";
        }

        return $code;
    }

    private function assign(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' = '
            . $this->revertAST($node->children[1]);
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

    private function assignRef(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' = &'
            . $this->revertAST($node->children[1]);
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
                $op = 'xor';
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
                assert(false, 'Unknown flag for AST_BINARY_OP found.');
        }

        return $this->revertAST($node->children[0])
            . " {$op} "
            . $this->revertAST($node->children[1]);
    }

    private function break(Node $node) : string
    {
        $code = 'break';

        if ($node->children[0] !== null) {
            $code .= " {$this->revertAST($node->children[0])}";
        }

        return $code;
    }

    private function call(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . $this->revertAST($node->children[1]);
    }

    private function cast(Node $node) : string
    {
        $code = '(';

        switch ($node->flags) {
            case \ast\flags\TYPE_NULL:
                $code .= 'unset';
                break;
            case \ast\flags\TYPE_BOOL:
                $code .= 'bool';
                break;
            case \ast\flags\TYPE_LONG:
                $code .= 'int';
                break;
            case \ast\flags\TYPE_DOUBLE:
                $code .= 'float';
                break;
            case \ast\flags\TYPE_STRING:
                $code .= 'string';
                break;
            case \ast\flags\TYPE_ARRAY:
                $code .= 'array';
                break;
            case \ast\flags\TYPE_OBJECT:
                $code .= 'object';
                break;
            default:
                assert(false, 'Unknown cast type in AST_CAST found.');
        }

        $code .= ') ' . $this->revertAST($node->children[0]);

        return $code;
    }

    private function catch(Node $node) : string
    {
        $code = ' catch (' . $this->revertAST($node->children[0]) . ' $' . $node->children[1] . ') {' . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[2]);

        --$this->indentationLevel;

        $code .= $this->indent() . '}';

        return $code;
    }

    private function catchList(Node $node) : string
    {
        $code = '';

        if (isset($node->children[0])) {
            $code .= $this->revertAST($node->children[0]);
        }

        return $code;
    }

    private function class(Node $node) : string
    {
        $code = '';

        if (isset($node->docComment)) {
            $code .= $node->docComment . PHP_EOL;
        }

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
                break;
            case 0:
                // no flag used
                break;
            default:
                assert(false, 'Unknown flag in AST_CLASS found.');
        }

        if ($node->children[0] !== null) {
            $extends .= " extends {$this->revertAST($node->children[0])}";
        }

        if ($node->children[1] !== null) {
            $implements .= " implements {$this->revertAST($node->children[1])}";
        }

        $code .= "{$modifier}{$type} {$node->name}{$extends}{$implements}"
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

    private function classConstDecl(Node $node) : string
    {
        return $this->constDecl($node);
    }

    private function clone(Node $node) : string
    {
        return "clone {$this->revertAST($node->children[0])}";
    }

    private function closure(Node $node) : string
    {
        $code = 'function ';

        if ($node->flags === \ast\flags\RETURNS_REF) {
            $code .= '&';
        }

        $code .= $this->revertAST($node->children[0]);

        if ($node->children[1] !== null) {
            $code .= ' use (' . $this->commaSeparatedValues($node->children[1]) . ')';
        }

        if ($node->children[3] !== null) {
            $code .= " : {$this->revertAST($node->children[3])}";
        }

        $code .= ' {' . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[2]);

        --$this->indentationLevel;

        return $code . $this->indent() . '};';
    }

    private function closureVar(Node $node) : string
    {
        $code = '';

        if ($node->flags === \ast\flags\PARAM_REF) {
            $code .= '&';
        }

        return $code . '$' . $node->children[0];
    }

    private function coalesce(Node $node) : string
    {
        return '('
            . $this->revertAST($node->children[0])
            . ' ?? '
            . $this->revertAST($node->children[1])
            . ')';
    }

    /**
     * Custom method for building comma-deliniated lists.
     */
    private function commaSeparatedValues(Node $node) : string
    {
        $aggregator = [];

        foreach($node->children as $child) {
            $aggregator[] = $this->revertAST($child);
        }

        return implode(', ', $aggregator);
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

    private function constDecl(Node $node, $setConst = true) : string
    {
        $code = '';

        if ($setConst) {
            $code .= 'const ';
        }

        $code .= $this->revertAST($node->children[0]);

        return $code;
    }

    private function constElem(Node $node) : string
    {
        return "{$node->children[0]} = {$this->revertAST($node->children[1])}";
    }

    private function continue(Node $node) : string
    {
        $code = 'continue';

        if ($node->children[0] !== null) {
            $code .= " {$this->revertAST($node->children[0])}";
        }

        return $code;
    }

    private function declare(Node $node) : string
    {
        $code = 'declare(' . $this->constDecl($node->children[0], false) . ')';

        return $code;
    }

    private function dim(Node $node) : string
    {
        $code = $this->revertAST($node->children[0]) . '[';
        
        if ($node->children[1] !== null) {
            $code .= $this->revertAST($node->children[1]);
        }

        $code .= ']';

        return $code;
    }

    private function doWhile(Node $node) : string
    {
        $code = 'do {' . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[0]);

        --$this->indentationLevel;

        return $code
            . $this->indent()
            . '} while ('
            . $this->revertAST($node->children[1])
            . ')';
    }

    private function echo(Node $node) : string
    {
        return "echo {$this->revertAST($node->children[0])}";
    }

    private function empty(Node $node) : string
    {
        return "empty({$this->revertAST($node->children[0])})";
    }

    private function encapsList(Node $node) : string
    {
        $code = '"';

        foreach ($node->children as $child) {
            if ($child instanceof Node) {
                $code .= '{' . $this->revertAST($child) . '}';
            } else {
                $code .= $this->sanitiseString($child);
            }
        }

        $code .= '"';

        return $code;
    }

    private function exit(Node $node) : string
    {
        $code = 'die';

        if ($node->children[0] !== null) {
            $code .= '(' . $this->revertAST($node->children[0]) .')';
        }

        return $code;
    }

    private function exprList(Node $node) : string
    {
        return $this->commaSeparatedValues($node);
    }

    private function for(Node $node) : string
    {
        $code = 'for ('
            . $this->commaSeparatedValues($node->children[0])
            . '; '
            . $this->commaSeparatedValues($node->children[1])
            . '; '
            . $this->commaSeparatedValues($node->children[2])
            . ') {'
            . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[3]);

        --$this->indentationLevel;

        return $code . $this->indent() . '}';
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

    private function foreach(Node $node) : string
    {
        $code = "foreach ({$this->revertAST($node->children[0])} as ";

        if (isset($node->children[2])) {
            $code .= "{$this->revertAST($node->children[2])} => ";
        }

        $code .= "{$this->revertAST($node->children[1])}) {" . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[3]);

        --$this->indentationLevel;

        return "{$code}{$this->indent()}}";
    }

    private function funcDecl(Node $node) : string
    {
        $code = '';

        if (isset($node->docComment)) {
            $code .= $node->docComment . PHP_EOL;
        }

        $code .= 'function ';

        if ($node->flags === \ast\flags\RETURNS_REF) {
            $code .= '&';
        }

        $code .= $node->name . $this->revertAST($node->children[0]);

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

        $code .= $this->indent() . '}' . PHP_EOL;

        return $code;
    }

    public function getCode(Node $node) : string
    {
        $code = '';

        if ($this->fromFile) {
            $code .= '<?php' . PHP_EOL . PHP_EOL;
        }

        return $code . $this->revertAST($node) . PHP_EOL;
    }

    public function global(Node $node) : string
    {
        return "global {$this->revertAST($node->children[0])}";
    }

    private function goto(Node $node) : string
    {
        return "goto {$node->children[0]}";
    }

    /**
     * For version 10 compatibility with php-ast extension
     */
    private function greater(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' > '
            . $this->revertAST($node->children[1]);
    }

    /**
     * For version 10 compatibility with php-ast extension
     */
    private function greaterEqual(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' >= '
            . $this->revertAST($node->children[1]);
    }

    private function groupUse(Node $node) : string
    {
        $code = "{$this->useAbstract($node)}{$node->children[0]}\{";

        $code .= $this->use($node->children[1], false); // a hack to not show 'use ' in block

        return $code . '};';
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
            $body = true;

            if ($node->children[$i]->children[0] !== null) {
                if ($i === 0) {
                    $code .= 'if ';
                } else {
                    $code .= ' elseif ';
                }

                $code .= $this->revertAST($node->children[$i]);
            } else {
                $code .= ' else';

                if ($node->children[$i]->children[1]->kind === \ast\AST_IF) {
                    $code .= $this->revertAST($node->children[$i]->children[1]);
                    $body = false;
                }
            }

            if ($body) {
                $code .= ' {' . PHP_EOL;

                ++$this->indentationLevel;

                $code .= $this->revertAST($node->children[$i]->children[1]);

                --$this->indentationLevel;

                $code .= $this->indent() . '}';
            }
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

    private function includeOrEval(Node $node) : string
    {
        $code = '';
        $arg = $this->revertAST($node->children[0]);

        switch ($node->flags) {
            case \ast\flags\EXEC_INCLUDE:
                $code .= "include {$arg}";
                break;
            case \ast\flags\EXEC_INCLUDE_ONCE:
                $code .= "include_once {$arg}";
                break;
            case \ast\flags\EXEC_REQUIRE:
                $code .= "require {$arg}";
                break;
            case \ast\flags\EXEC_REQUIRE_ONCE:
                $code .= "require_once {$arg}";
                break;
            case \ast\flags\EXEC_EVAL:
                $code .= "eval({$arg})";
                break;
            default:
                assert(false, 'Unknown flag in AST_INCLUDE_OR_EVAL found.'); // \ast\flags\EXEC_EVAL
        }

        return $code;
    }

    private function instanceof(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' instanceof '
            . $this->revertAST($node->children[1]);
    }

    /**
     * Custom method to indent statements
     */
    private function indent() : string
    {
        return str_repeat(
            self::INDENTATION_CHAR,
            $this->indentationLevel * self::INDENTATION_SIZE
        );
    }

    private function isset(Node $node) : string
    {
        return "isset({$this->revertAST($node->children[0])})";
    }

    private function label(Node $node) : string
    {
        return "{$node->children[0]}:" . PHP_EOL;
    }

    private function list(Node $node) : string
    {
        return 'list('
            . $this->commaSeparatedValues($node)
            . ')';
    }

    private function magicConst($node)
    {
        // $node = null when in namespace with braces
        // ignore for now

        return ''; // keep revertAST happy
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
                assert(false, 'Unknown flag(s) in AST_METHOD found.');
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

    private function methodReference(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . '::'
            . $node->children[1];
    }

    private function name(Node $node) : string
    {
        return $node->children[0];
    }

    private function nameList(Node $node) : string
    {
        return $this->commaSeparatedValues($node);
    }

    private function namespace(Node $node) : string
    {
        $code = "namespace {$node->children[0]}";

        if ($node->children[1] !== null) {
            $code .= ' {' . PHP_EOL;

            ++$this->indentationLevel;

            $code .=  $this->revertAST($node->children[1]);

            --$this->indentationLevel;

            $code .= $this->indent() . '};' . PHP_EOL;
        }

        return $code;
    }

    private function new(Node $node) : string
    {
        $code = 'new ' . $this->revertAST($node->children[0]);

        if ($node->children[1] !== null) {
            $code .= $this->revertAST($node->children[1]);
        }

        return $code;
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
        return '('
            . $this->commaSeparatedValues($node)
            . ')';
    }

    private function postDec(Node $node) : string
    {
        return $this->revertAst($node->children[0]) . '--';
    }

    private function postInc(Node $node) : string
    {
        return $this->revertAst($node->children[0]) . '++';
    }

    private function preDec(Node $node) : string
    {
        return '--' . $this->revertAst($node->children[0]);
    }

    private function preInc(Node $node) : string
    {
        return '++' . $this->revertAst($node->children[0]);
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
                assert(false, 'Unknown flag(s) in AST_PROP_DECL found.');
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

    private function silence(Node $node) : string
    {
        return "@{$this->revertAST($node->children[0])}";
    }

    private function sanitiseString(string $string) : string
    {
        return strtr($string, ['\\' => '\\\\', "\n" => '\n', '"' => '\"']);
    }

    private function static(Node $node) : string
    {
        $code = "static \${$node->children[0]}";

        if ($node->children[1] !== null) {
            $code .= " = {$this->revertAST($node->children[1])}";
        }

        return $code;
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
    {
        $code = '';

        foreach ($node->children as $child) {
            if ($child === null) {
                continue;
            }

            if (!$child instanceof Node || $child->kind !== \ast\AST_STMT_LIST) {
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
        $code = "switch ({$this->revertAST($node->children[0])}) {" . PHP_EOL;

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

    private function throw(Node $node) : string
    {
        return "throw {$this->revertAST($node->children[0])}";
    }

    private function traitAdaptations(Node $node) : string
    {
        $code = '';

        foreach ($node->children as $child) {
            $code .= $this->indent()
                . $this->revertAST($child)
                . ';'
                . PHP_EOL;
        }

        return $code;
    }

    private function traitAlias(Node $node) : string
    {
        $code = $this->revertAST($node->children[0])
            . ' as ';

        switch ($node->flags) {
            case \ast\flags\MODIFIER_PUBLIC:
                $code .= 'public ';
                break;
            case \ast\flags\MODIFIER_PROTECTED:
                $code .= 'protected ';
                break;
            case \ast\flags\MODIFIER_PRIVATE:
                $code .= 'private ';
                break;
        }

        return $code . $node->children[1];
    }

    private function traitPrecedence(Node $node) : string
    {
        return $this->revertAST($node->children[0])
            . ' insteadof '
            . $this->revertAST($node->children[1]);
    }

    private function try(Node $node) : string
    {
        $code = 'try {' . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[0]);

        --$this->indentationLevel;

        $code .= $this->indent() . '}';

        $code .= $this->revertAST($node->children[1]);

        if ($node->children[2] !== null) {
            $code .= ' finally {' . PHP_EOL;

            ++$this->indentationLevel;

            $code .= $this->revertAST($node->children[2]);

            -- $this->indentationLevel;

            $code .= $this->indent() . '}';
        }

        return $code;
    }

    private function type(Node $node) : string
    {
        switch ($node->flags) {
            case \ast\flags\TYPE_ARRAY:
                return 'array';
            case \ast\flags\TYPE_CALLABLE:
                return 'callable';
            default:
                assert(false, 'Unknown flag in AST_TYPE found.');
        }
    }

    private function unaryMinus(Node $node) : string
    {
        return "-{$this->revertAST($node->children[0])}";
    }

    private function unaryOp(Node $node) : string
    {
        $code = '';

        switch ($node->flags) {
            case \ast\flags\UNARY_BOOL_NOT:
                $code .= '!';
                break;
            case \ast\flags\UNARY_BITWISE_NOT:
                $code .= '~';
                break;
            default:
                assert(false, 'Unknown flag in AST_UNARY_OP found.');
        }

        $code .= $this->revertAST($node->children[0]);

        return $code;
    }

    private function unaryPlus(Node $node) : string
    {
        return $this->revertAST($node->children[0]); // removes the unary plus
    }

    private function unpack(Node $node) : string
    {
        return "...{$this->revertAST($node->children[0])}";
    }

    private function use(Node $node, $setUse = true) : string
    {
        return $this->useAbstract($node, $setUse)
            . $this->commaSeparatedValues($node);
    }

    /**
     * Custom method to encapsulate common logic between use() and groupUse().
     */
    private function useAbstract(Node $node, $setUse = true) : string
    {
        $code = '';

        if ($setUse) {
            $code .= 'use ';
        }

        switch ($node->flags) {
            case T_CLASS:
                // nothing to do here
                break;
            case T_FUNCTION:
                $code .= 'function ';
                break;
            case T_CONST:
                $code .= 'const ';
                break;
            default:
                // Not possible to do the following assetion since 0 can denote T_CLASS
                // assert(false, 'Unknown flag found.');
        }

        return $code;
    }

    private function useElem(Node $node) : string
    {
        $code = $node->children[0];

        if ($node->children[1] !== null) {
            $code .= " as {$node->children[1]}";
        }

        return $code;
    }

    private function useTrait(Node $node) : string
    {
        $code = 'use ';

        $code .= $this->commaSeparatedValues($node->children[0]);

        if ($node->children[1] !== null) {
            $code .= ' {' . PHP_EOL;

            ++$this->indentationLevel;

            $code .= $this->revertAST($node->children[1]);

            --$this->indentationLevel;

            $code .= $this->indent() . '}' . PHP_EOL;
        }

        return $code;
    }

    private function var(Node $node) : string
    {
        $code = '$';

        if (!$node->children[0] instanceof Node) {
            $varName = $node->children[0];

            if (preg_match('~^[_a-z][_a-z0-9]*$~i', $varName)) {
                return $code . $varName;
            } else {
                return $code . "{'{$varName}'}";
            }
            
        }

        return "{$code}{{$this->revertAST($node->children[0])}}";
    }

    private function while(Node $node) : string
    {
        $code = "while ({$this->revertAST($node->children[0])}) {" . PHP_EOL;

        ++$this->indentationLevel;

        $code .= $this->revertAST($node->children[1]);

        --$this->indentationLevel;

        return $code . $this->indent() . '}';
    }

    private function yield(Node $node) : string
    {
        return "yield {$this->revertAST($node->children[0])}";
    }

    private function yieldFrom(Node $node) : string
    {
        return "yield from {$this->revertAST($node->children[0])}";
    }
}
