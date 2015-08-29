Function Test
<=======>
<?php

function test(int $a=[],$b=null,StdClass ...$c){}
if (1){
function &test(){}}
function a(){static $a =a();}
<=======>
<?php

function test(int $a = [], $b = null, StdClass ...$c)
{
}
if (1) {
    function &test()
    {
    }
}
function a()
{
    static $a = a();
}
