Language Constructs Test
<=======>
<?php

echo $a;
echo '1';
echo "${$a}";
echo 1.2;
echo 1.0;
print("$a");
die;
die("$a");
exit(1);
<=======>
echo $a;
echo '1';
echo "{${$a}}";
echo 1.2;
echo 1;
print "{$a}";
die;
die("{$a}");
die(1);
