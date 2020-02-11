<?php
namespace Main;

require_once 'BasicObject.php';
require_once 'QueryStringItem.php';

use \Main\BasicObject;
use \Main\QueryStringItem;


class ListAction extends BasicObject
{
	private $_actionName;
	private $_actionDescription;
	private $_actionHref;
	private $_queryStringItems = [];
	
    public function __construct($actionName, $actionHref, $actionDescription, $queryStringItems)
    {
        $this->_actionName = $actionName;
		$this->_actionDescription = $actionDescription;
		$this->_actionHref = $actionHref;
		foreach ($queryStringItems as $qsItem)
		{
			$this->_queryStringItems[] = $qsItem;
		}
		
		
    }
	
	public function GetActionElement($id)
	{
		$qsAppend = "";
		if(!empty($this->_queryStringItems))
		{
			foreach($this->_queryStringItems as $qs)
			{
				$qsAppend = $qsAppend."&$qs->key=$qs->value";
			}
		}		
		return "<a href='$this->_actionHref.php?id=$id$qsAppend'><input id='btn$this->_actionName' type='button' value='$this->_actionDescription'/></a>";
	}
}


?>