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
final class Test{}
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
final class Test
{
}
