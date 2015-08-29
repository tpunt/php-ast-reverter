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
empty($a);
goto a;
clone $a->b();
global $a, $b;
declare(strict_types=1);
if (1) {$a;}
if (1) {$a;} elseif (2) {$b;}
if (1) {$a;} elseif (2) {$b;} else {$c;}
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
empty($a);
goto a;
clone $a->b();
global $a;
global $b;
declare(strict_types = 1);
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
