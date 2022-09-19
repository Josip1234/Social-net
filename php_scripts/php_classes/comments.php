<?php
include("users.php");
class Comment extends User{
	public $date_record;
	public $date_of_change;
	public $record;
	public $like;
	public $dislike;
	public $number_of_comments;

	public function __construct($date_record, $date_of_change, $record, $like, $dislike, $number_of_comments)
	{
		$this->date_record = $date_record;
		$this->date_of_change = $date_of_change;
		$this->record = $record;
		$this->like = $like;
		$this->dislike = $dislike;
		$this->number_of_comments = $number_of_comments;
	}
	

	/**
	 * Get the value of date_record
	 */ 
	public function getDate_record()
	{
		return $this->date_record;
	}

	/**
	 * Set the value of date_record
	 *
	 * @return  self
	 */ 
	public function setDate_record($date_record)
	{
		$this->date_record = $date_record;

		return $this;
	}

	/**
	 * Get the value of date_of_change
	 */ 
	public function getDate_of_change()
	{
		return $this->date_of_change;
	}

	/**
	 * Set the value of date_of_change
	 *
	 * @return  self
	 */ 
	public function setDate_of_change($date_of_change)
	{
		$this->date_of_change = $date_of_change;

		return $this;
	}

	/**
	 * Get the value of record
	 */ 
	public function getRecord()
	{
		return $this->record;
	}

	/**
	 * Set the value of record
	 *
	 * @return  self
	 */ 
	public function setRecord($record)
	{
		$this->record = $record;

		return $this;
	}

	/**
	 * Get the value of like
	 */ 
	public function getLike()
	{
		return $this->like;
	}

	/**
	 * Set the value of like
	 *
	 * @return  self
	 */ 
	public function setLike($like)
	{
		$this->like = $like;

		return $this;
	}

	/**
	 * Get the value of dislike
	 */ 
	public function getDislike()
	{
		return $this->dislike;
	}

	/**
	 * Set the value of dislike
	 *
	 * @return  self
	 */ 
	public function setDislike($dislike)
	{
		$this->dislike = $dislike;

		return $this;
	}

	/**
	 * Get the value of number_of_comments
	 */ 
	public function getNumber_of_comments()
	{
		return $this->number_of_comments;
	}

	/**
	 * Set the value of number_of_comments
	 *
	 * @return  self
	 */ 
	public function setNumber_of_comments($number_of_comments)
	{
		$this->number_of_comments = $number_of_comments;

		return $this;
	}

}


?>