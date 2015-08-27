Method Definitions Test
<=======>
<?php

class Test
{
    /**
     * DocComment
     */
    public static abstract function method() : int {return 1;}
}
<=======>
class Test
{
    /**
     * DocComment
     */
    abstract public static function method() : int
    {
        return 1;
    }
}
