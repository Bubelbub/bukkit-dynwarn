<?php

/**
 * The user from authme etc.
 *
 * @author Bubelbub <bubelbub@gmail.com>
 */
class User
{

	/**
	 *
	 * @var string|integer the id of the user (it could be a guid (string))
	 */
	private $id;

	/**
	 * @var string the name of the user
	 */
	private $name;

	/**
	 * Creates a user (not loaded from database!)
	 * 
	 * @param string|integer $id the id or guid of the user
	 * @param string $name the name of the user
	 */
	public function __construct($id = null, $name = null)
	{
		$this->setId($id);
		$this->setName($name);
	}

	/**
	 * Sets the id of the user
	 * 
	 * @param integer $id the id or guid of the user
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Gets the id of the user
	 * 
	 * @return string|integer the id or guid of the user
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Sets the name of the user
	 * 
	 * @param string $name the name of the user
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Gets the name of the user
	 * 
	 * @return string the name of the user
	 */
	public function getName()
	{
		return $this->name;
	}

}
