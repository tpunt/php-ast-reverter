Class Definitions Test
<=======>
<?php

class Test{}
class Test implements SomeInterface{}
class Test implements SomeInterface,SomeotherInterface{}
class Test extends SomeClass{}
class Test extends SomeClass implements SomeInterface{}
abstract class Test{}
final class Test{}
<=======>
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
final class Test
{

}
