Class Definitions Test
<=======>
<?php

/**
 * DocComment here...
 */
class Test{}
class Test implements SomeInterface{}
class Test implements SomeInterface,SomeotherInterface{}
class Test extends SomeClass{}
class Test extends SomeClass implements SomeInterface{}
abstract class Test{}
abstract class fail{abstract public function show();}
final class Test{}
new class(10) extends SomeClass implements SomeInterface {
    private $num;

    public function __construct($num)
    {
        $this->num = $num;
    }

    use SomeTrait;
};
interface SomeInterface {}
interface ArrayProxyAccess extends ArrayAccess{}
<=======>
<?php

/**
 * DocComment here...
 */
class Test
{
}
class Test implements SomeInterface
{
}
class Test implements SomeInterface, SomeotherInterface
{
}
class Test extends SomeClass
{
}
class Test extends SomeClass implements SomeInterface
{
}
abstract class Test
{
}
abstract class fail
{
    abstract public function show();
}
final class Test
{
}
new class (10) extends SomeClass implements SomeInterface {
    private $num;
    public function __construct($num)
    {
        $this->num = $num;
    }
    use SomeTrait;
};
interface SomeInterface
{
}
interface ArrayProxyAccess extends ArrayAccess
{
}
