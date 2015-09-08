Property Definitions Test
<=======>
<?php

class Test{
public $a;
    /**
     * DocComment here
     */
 protected static $b = 1;
private static $c;
static $d;}
<=======>
<?php

class Test
{
    public $a;
    /**
     * DocComment here
     */
    protected static $b = 1;
    private static $c;
    static $d;
}
