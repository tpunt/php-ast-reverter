Closures Test
<=======>
<?php

$a = function &($a) use ($b, &$c) : int {return 1;};
<=======>
$a = function &($a) use ($b, &$c) : int {
    return 1;
};
