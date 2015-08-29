Namespaces Test
<=======>
<?php

use a\b\C;
use a\b\C as D;
use const a\b\C;
use const a\b\C as D;
use function a\b\C;
use function a\b\C as D;
use a\b\{C as D, E};
use const a\b\{C as D, E};
use function a\b\{C as D, E};

namespace test {
$a;
$b;
};
namespace test2 {
$c;
};
<=======>
<?php

use a\b\C;
use a\b\C as D;
use const a\b\C;
use const a\b\C as D;
use function a\b\C;
use function a\b\C as D;
use a\b\{C as D, E};
use const a\b\{C as D, E};
use function a\b\{C as D, E};
namespace test {
    $a;
    $b;
};
namespace test2 {
    $c;
};
