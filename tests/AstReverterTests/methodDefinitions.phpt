Method Definitions Test
<=======>
<?php

class Test
{
    /**
     * DocComment
     */
    public static abstract function method() : int {return 1;}

    public function method(){}
    public function &method(){}
    abstract public function method(){}
    abstract public function &method(){}
    final public function method(){}
    final public function &method(){}
    public static function method(){}
    public static function &method(){}
    abstract public static function method(){}
    abstract public static function &method(){}
    final public static function method(){}
    final public static function &method(){}

    protected function method(){}
    protected function &method(){}
    abstract protected function method(){}
    abstract protected function &method(){}
    final protected function method(){}
    final protected function &method(){}
    protected static function method(){}
    protected static function &method(){}
    abstract protected static function method(){}
    abstract protected static function &method(){}
    final protected static function method(){}
    final protected static function &method(){}

    private function method(){}
    private function &method(){}
    abstract private function method(){}
    abstract private function &method(){}
    final private function method(){}
    final private function &method(){}
    private static function method(){}
    private static function &method(){}
    abstract private static function method(){}
    abstract private static function &method(){}
    final private static function method(){}
    final private static function &method(){}
}
<=======>
<?php

class Test
{
    /**
     * DocComment
     */
    abstract public static function method() : int
    {
        return 1;
    }
    public function method()
    {
    }
    public function &method()
    {
    }
    abstract public function method()
    {
    }
    abstract public function &method()
    {
    }
    final public function method()
    {
    }
    final public function &method()
    {
    }
    public static function method()
    {
    }
    public static function &method()
    {
    }
    abstract public static function method()
    {
    }
    abstract public static function &method()
    {
    }
    final public static function method()
    {
    }
    final public static function &method()
    {
    }
    protected function method()
    {
    }
    protected function &method()
    {
    }
    abstract protected function method()
    {
    }
    abstract protected function &method()
    {
    }
    final protected function method()
    {
    }
    final protected function &method()
    {
    }
    protected static function method()
    {
    }
    protected static function &method()
    {
    }
    abstract protected static function method()
    {
    }
    abstract protected static function &method()
    {
    }
    final protected static function method()
    {
    }
    final protected static function &method()
    {
    }
    private function method()
    {
    }
    private function &method()
    {
    }
    abstract private function method()
    {
    }
    abstract private function &method()
    {
    }
    final private function method()
    {
    }
    final private function &method()
    {
    }
    private static function method()
    {
    }
    private static function &method()
    {
    }
    abstract private static function method()
    {
    }
    abstract private static function &method()
    {
    }
    final private static function method()
    {
    }
    final private static function &method()
    {
    }
}
