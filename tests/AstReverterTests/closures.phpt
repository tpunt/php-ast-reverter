Closures Test
<=======>
<?php

$a = function &($a) use ($b, &$c) : int {return 1;};
function &($a) use ($b, &$c) : int {return 1;};
func(function &($a) use ($b, &$c) : int {return 1;});
<=======>
<?php

$a = function &($a) use ($b, &$c) : int {
    return 1;
};
function &($a) use ($b, &$c) : int {
    return 1;
};
func(function &($a) use ($b, &$c) : int {
    return 1;
});
