Try/Catch/Finally
<=======>
<?php
try {
    $a;
} catch (Exception $e) {
    $b;
} catch (Throwable $t) {
    $c;
} finally {
    $d;
}

try {
    $a;
} finally {
    $b;
}

try {
    $a;
} catch (Exception $e) {
    $b;
}
<=======>
<?php

try {
    $a;
} catch (Exception $e) {
    $b;
} catch (Throwable $t) {
    $c;
} finally {
    $d;
}
try {
    $a;
} finally {
    $b;
}
try {
    $a;
} catch (Exception $e) {
    $b;
}
