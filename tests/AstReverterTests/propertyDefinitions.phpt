Property Definitions Test
<=======>
<?php

class Test{
    /**
     * DocComment here
     */
public $a;

 protected
    /**
     * b
     */
    $b = 1,
    /**
     * c
     */
    $c = 2;
private static $c;
static $d;}
<=======>
<?php

class Test
{
    public
    /**
     * DocComment here
     */
    $a;
    protected
    /**
     * b
     */
    $b = 1,
    /**
     * c
     */
    $c = 2;
    private static $c;
    static $d;
}
<=======>
20