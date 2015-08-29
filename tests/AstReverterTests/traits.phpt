Traits Test
<=======>
<?php

trait Test{}
trait Test2{private $a;protected $b = 1; public function test() {}}
trait Test3{public function test() {}private function test2() {}}
class Test
{
    use Test;
    use Test2, Test3 {
        Test2::test insteadof Test3;
        Test3::test as test0;
        Test3::test2 as public test2;
    }
}
<=======>
<?php

trait Test
{
}
trait Test2
{
    private $a;
    protected $b = 1;
    public function test()
    {
    }
}
trait Test3
{
    public function test()
    {
    }
    private function test2()
    {
    }
}
class Test
{
    use Test;
    use Test2, Test3 {
        Test2::test insteadof Test3;
        Test3::test as test0;
        Test3::test2 as public test2;
    }
}
