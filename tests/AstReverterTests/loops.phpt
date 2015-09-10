Loops Test
<=======>
<?php


while (true) {
    1;
}
do {
    true;
} while (false);
foreach ($a as $b => $c){}
foreach($arr as $key => &$val){}
for ($a = 0, $b = 0; $a > 10, $b >= 1; ++$a, $b--) {
    'a';
}
for(;;){}
for(;;);
for (;;) $a;
while(0);
while (1) $a;
foreach($a as $b);
foreach ($a as $b) $b;
<=======>
<?php

while (true) {
    1;
}
do {
    true;
} while (false);
foreach ($a as $b => $c) {
}
foreach ($arr as $key => &$val) {
}
for ($a = 0, $b = 0; $a > 10, $b >= 1; ++$a, $b--) {
    "a";
}
for (;;) {
}
for (;;);
for (;;) {
    $a;
}
while (0);
while (1) {
    $a;
}
foreach ($a as $b);
foreach ($a as $b) {
    $b;
}
