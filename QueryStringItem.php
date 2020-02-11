<?php
namespace Main;

require_once 'BasicObject.php';

use \Main\BasicObject;

class QueryStringItem
{
	public $key;
	public $value;
	
    public function __construct($key, $value)
    {
        $this->key = $key;
		$this->value = $value;
    }
}


?>