<?php 
class Form{
	//if admin wants another form this class will be used to create it
	//only most common values will be generated because there is too many of values to generate
	//also we will implement requests to add new values if needed.
	//this will also be in database.
	public $form_element_name; //for example text will be input text, input email, input password
	public $form_element_values; //special validation rules by html, or class names
	
	
		public function __construct($form_element_name, $form_element_values)
	{
		$this->form_element_name = $form_element_name;
		$this->form_element_values = $form_element_values;
	}
	

	/**
	 * Get the value of form element name
	 */ 
	public function getForm_element_name()
	{
		return $this->form_element_name;
	}

	/**
	 * Set the value of form element name
	 *
	 * @return  self
	 */ 
	public function setForm_element_name($form_element_name)
	{
		$this->form_element_name = $form_element_name;

		return $this;
	}
	
		/**
	 * Get the value of form_element_values
	 */ 
	public function getForm_element_values()
	{
		return $this->form_element_values;
	}

	/**
	 * Set the value of form_element_values
	 *
	 * @return  self
	 */ 
	public function setForm_element_values($form_element_values)
	{
		$this->form_element_values = $form_element_values;

		return $this;
	}
	
	
}


?>