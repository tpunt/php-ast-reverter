Closures Test
<=======>
<?php

function a($a) {yield 1;}
function b($b) {yield from a();}
<=======>
<?php

function a($a)
{
    yield 1;
}
function b($b)
{
    yield from a();
}
