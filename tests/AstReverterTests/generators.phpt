Closures Test
<=======>
<?php

function a($a) {
    yield;
    yield 1;
    yield 'foo' => 'bar';
}
function b($b) {yield from a();}
<=======>
<?php

function a($a)
{
    yield;
    yield 1;
    yield "foo" => "bar";
}
function b($b)
{
    yield from a();
}
