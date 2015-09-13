Misc Test
<=======>
<?php

a:
if (1) {
    try {
     $a;
    } catch (Exception $e) {
        $b;
    } finally {
        $c;
    }
}
[1 => 2, 3=>4, 5, 6, a(), b() => c];
(string) $a;
(bool) $a;
(float) $a;
(int) $a;
(array) $a;
(object) $a;
(unset) $a;
$a = &$b;
function &a(&$a){}
__LINE__;
__FILE__;
__DIR__;
__TRAIT__;
__METHOD__;
__FUNCTION__;
__NAMESPACE__;
__CLASS__;
(new SomeClass)->invokeMethod();
`a$a`;
$a .= "a";
$a += 1;
$a -= 1;
$a /= 1;
$a *= 1;
$a ^= 1;
$a |= 1;
$a &= 1;
$a %= 1;
$a **= 1;
$a <<= 1;
$a >>= 1;
$b = ${$a};
$a += ${$b};
$a{$a+=$b};
($a <=> $b) === 1;
($a === 1) === 2;
$a === (1 === 2);
($a === 3) !== true;
1 << ($a === 1);
<=======>
<?php

a:
if (1) {
    try {
        $a;
    } catch (Exception $e) {
        $b;
    } finally {
        $c;
    }
}
[1 => 2, 3 => 4, 5, 6, a(), b() => c];
(string) $a;
(bool) $a;
(float) $a;
(int) $a;
(array) $a;
(object) $a;
(unset) $a;
$a = &$b;
function &a(&$a)
{
}
__LINE__;
__FILE__;
__DIR__;
__TRAIT__;
__METHOD__;
__FUNCTION__;
__NAMESPACE__;
__CLASS__;
(new SomeClass())->invokeMethod();
`a{$a}`;
$a .= "a";
$a += 1;
$a -= 1;
$a /= 1;
$a *= 1;
$a ^= 1;
$a |= 1;
$a &= 1;
$a %= 1;
$a **= 1;
$a <<= 1;
$a >>= 1;
$b = ${$a};
$a += ${$b};
$a[$a += $b];
($a <=> $b) === 1;
($a === 1) === 2;
$a === (1 === 2);
($a === 3) !== true;
1 << ($a === 1);
