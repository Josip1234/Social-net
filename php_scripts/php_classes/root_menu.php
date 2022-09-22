<?php
class  Root{
	public $name;
	public $class;
	public $html_tag;

	public function __construct($name,$class,$html_tag)
{
    $this->name = $name;
    $this->class = $class;
    $this->html_tag = $html_tag;
}

function __destruct() {
	$this->name = "";
    $this->class = "";
    $this->html_tag = "";
  }

	/**
	 * Get the value of name
	 */ 
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @return  self
	 */ 
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of class
	 */ 
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * Set the value of class
	 *
	 * @return  self
	 */ 
	public function setClass($class)
	{
		$this->class = $class;

		return $this;
	}

	/**
	 * Get the value of html_tag
	 */ 
	public function getHtml_tag()
	{
		return $this->html_tag;
	}

	/**
	 * Set the value of html_tag
	 *
	 * @return  self
	 */ 
	public function setHtml_tag($html_tag)
	{
		$this->html_tag = $html_tag;

		return $this;
	}
}

?>