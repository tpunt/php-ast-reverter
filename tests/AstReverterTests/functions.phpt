Function Test
<=======>
<?php

function test(int $a=[],$b=null,StdClass ...$c){}
if (1){
function &test(){}}
<=======>
function test(int $a = [], $b = null, StdClass ...$c)
{
}
if (1) {
    function &test()
    {
    }
}
