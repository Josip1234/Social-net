<?php 
include("root_menu.php");
class Submenu extends Root{
	public $previous_child_name;
	public $previous_class_name;
	public $submenu_name;
	public $html_tag;
	public $class;

	public function __construct($submenu_name,$html_tag,$class)
	{   
		$this->$previous_child_name = $this->name;
		$this->$previous_class_name = $this->class;
		$this->submenu_name = $submenu_name;
		$this->html_tag = $html_tag;
		$this->class = $class;

	}
	function __destruct() {
		$this->submenu_name = "";
		$this->html_tag = "";
		$this->class = "";
	  }


	/**
	 * Get the value of previous_child_name
	 */ 
	public function getPrevious_child_name()
	{
		return $this->previous_child_name;
	}

	/**
	 * Set the value of previous_child_name
	 *
	 * @return  self
	 */ 
	public function setPrevious_child_name($previous_child_name)
	{
		$this->previous_child_name = $previous_child_name;

		return $this;
	}

	/**
	 * Get the value of previous_class_name
	 */ 
	public function getPrevious_class_name()
	{
		return $this->previous_class_name;
	}

	/**
	 * Set the value of previous_class_name
	 *
	 * @return  self
	 */ 
	public function setPrevious_class_name($previous_class_name)
	{
		$this->previous_class_name = $previous_class_name;

		return $this;
	}

	/**
	 * Get the value of submenu_name
	 */ 
	public function getSubmenu_name()
	{
		return $this->submenu_name;
	}

	/**
	 * Set the value of submenu_name
	 *
	 * @return  self
	 */ 
	public function setSubmenu_name($submenu_name)
	{
		$this->submenu_name = $submenu_name;

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
}
?>