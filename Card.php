<?


class Card
{
	private _name;
	private _cardText;
	
	public function __construct($name, $cardText)
	{
		$this->_name = $name;
		$this->)_cardText = $cardText;
	}
	
	public function UpdateName($value)
	{
		$this->_name = $value;
		return;
	}	
	
	public function UpdateCardText($value)
	{
		$this->_cardText = $value;
		return;
	}	
	
	
	
}

?>