<?php
namespace Main;

class BasicObject
{
    public function __get($property)
    {
		$method = "Get{$property}";
		if(method_exists($this, $method))
		{
			return $this->$method();
		}
		return;
    }
	
    public function __set($property, $value)
    {
        $method = "Set{$property}";
        if(method_exists($this, $method))
        {
            $this->$method($value);
        }
        return;
    }
}
?>