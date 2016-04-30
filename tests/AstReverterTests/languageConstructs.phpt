Language Constructs Test
<=======>
<?php

echo $a;
echo '1';
echo "${$a}a";
echo 1.2;
echo 1.0;
print("$a");
die;
die("$a");
die($a = 1);
exit(1);
include ('a') . 'aa' . ('aaa');
include_once 'b';
require 'c';
require_once 'd';
eval('a');
break;
break 2;
break $n;
continue;
continue 2;
continue $n;
isset($a);
isset($a, $b);
unset($a, $b);
empty($a);
goto a;
clone $a->b();
global $a, $b;
global $$c;
declare(strict_types=1);
declare(a=1,b=2);
declare(ticks=1) {$a;}
const afunction=3,ause=4;
if (1) {$a;}
if (1) {$a;} elseif (2) {$b;}
if (1) {$a;} elseif (2) {$b;} else {$c;}
if (1) {
    $a;
} else if (2) {
    $b;
} elseif (3) {
    $c;
} else {
    $d;
}
if (0) {
    $a;
} else {
    if(1)
        if (2) {

        }
}
if (1);
list(,,$a) = [];
<=======>
<?php

echo $a;
echo "1";
echo "{${$a}}a";
echo 1.2;
echo 1;
print "{$a}";
die;
die("{$a}");
die($a = 1);
die(1);
include "a" . "aa" . "aaa";
include_once "b";
require "c";
require_once "d";
eval("a");
break;
break 2;
break $n;
continue;
continue 2;
continue $n;
isset($a);
isset($a) && isset($b);
unset($a);
unset($b);
empty($a);
goto a;
clone $a->b();
global $a;
global $b;
global ${$c};
declare(strict_types = 1);
declare(a = 1, b = 2);
declare(ticks = 1) {
    $a;
}
const afunction = 3, ause = 4;
if (1) {
    $a;
}
if (1) {
    $a;
} elseif (2) {
    $b;
}
if (1) {
    $a;
} elseif (2) {
    $b;
} else {
    $c;
}
if (1) {
    $a;
} else {
    if (2) {
        $b;
    } elseif (3) {
        $c;
    } else {
        $d;
    }
}
if (0) {
    $a;
} else {
    if (1) {
        if (2) {
        }
    }
}
if (1);
list(, , $a) = [];
