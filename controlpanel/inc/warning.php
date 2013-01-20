<?php

/**
 * This is a warning
 *
 * @author Bubelbub <bubelbub@gmail.com>
 */
class Warning
{

	/**
	 *
	 * @var integer the id of the warning
	 */
	private $id;

	/**
	 * @var string the name of the user (the user which was warned)
	 */
	private $username;

	/**
	 * @var string the name of the user which warns $username
	 */
	private $username_warner;

	/**
	 * @var string the reason why the user is banned
	 */
	private $reason;

	/**
	 * @var integer the timestamp when the user was warned
	 */
	private $date;

	/**
	 * @var boolean is the warning deleted? (only relevant if MySQL_optional_remove_entries = false)
	 */
	private $deleted;

	/**
	 * Creates a warning (not loaded from database!)
	 * 
	 * @param string|integer $id the id or guid of the user
	 * @param string $name the name of the user
	 */
	public function __construct($id = null, $username = null, $username_warner = null, $reason = null, $date = null, $deleted = false)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setUsernameWarner($username_warner);
		$this->setReason($reason);
		$this->setDate($date);
		$this->setDeleted($deleted);
	}

	/**
	 * Loads a warning with the id $id
	 * 
	 * @param Database $database the database to use for the load
	 * @param type $id the id of the warning to load
	 * @throws Exception if the item could not found
	 */
	public function load(Database $database, $id)
	{
		$item = $database->getEntry(MySQL_prefix . 'warns', $id);
		if ($item != null)
		{
			$this->setId($item['id']);
			$this->setUsername($item['username']);
			$this->setUsernameWarner($item['username_warner']);
			$this->setReason($item['reason']);
			$this->setDate($item['date']);
			$this->setDeleted($item['deleted']);
		}
		else
		{
			throw new Exception('404 - Item ' . $id . ' could not found!');
		}
	}

	/**
	 * Saves this warning
	 * 
	 * @param Database $database the database to use for the load
	 * @throws Exception if the item could not saved
	 */
	public function save(Database $database)
	{
		$updateArray = array();
		$updateArray['username']		 = $this->getUsername();
		$updateArray['username_warner']	 = $this->getUsernameWarner();
		$updateArray['reason']			 = $this->getReason();
		$updateArray['date']			 = $this->getDate();
		$updateArray['deleted']			 = $this->isDeleted();
		if (!$database->saveEntry(MySQL_prefix . 'warns', $this->getId(), $updateArray))
		{
			throw new Exception('404 - Item ' . $this->getId() . ' could not saved!');
		}
	}

	/**
	 * Delete this warning
	 * 
	 * @param Database $database the database to use for the load
	 * @return boolean if this warning is deleted : true, or not : false
	 * @throws Exception if the item could not deleted
	 */
	public function delete(Database $database)
	{
		$deleted = false;
		if (defined('MySQL_optional_remove_entries'))
		{
			if (MySQL_optional_remove_entries == true)
			{
				$updateArray = array();
				$updateArray['deleted'] = true;
				if (!$database->saveEntry(MySQL_prefix . 'warns', $this->getId(), $updateArray))
				{
					throw new Exception('404 - Item ' . $this->getId() . ' could not saved!');
				}
				else
				{
					$deleted = true;
				}
			}
		}
		if (!$deleted)
		{
			if (!$database->deleteEntry(MySQL_prefix . 'warns', $this->getId()))
			{
				throw new Exception('404 - Item ' . $this->getId() . ' could not removed!');
			}
			else
			{
				$deleted = true;
			}
		}
		return $deleted;
	}

	/**
	 * Sets the id of the warning
	 * 
	 * @param integer $id the id of the warning
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Gets the id of the warning
	 * 
	 * @return integer the id of the warning
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Sets the username of the warning
	 * 
	 * @param string $username the name of the user (the user which was warned)
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * Gets the username of the warning
	 * 
	 * @return string the name of the user (the user which was warned)
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Sets the username_warner of the warning
	 * 
	 * @param string $usernameWarner the name of the user which warns $username
	 */
	public function setUsernameWarner($usernameWarner)
	{
		$this->username_warner = $usernameWarner;
	}

	/**
	 * Gets the username_warner of the warning
	 * 
	 * @return string the name of the user which warns $username
	 */
	public function getUsernameWarner()
	{
		return $this->username_warner;
	}

	/**
	 * Sets the reason of the warning
	 * 
	 * @param string $reason the reason why the user is banned
	 */
	public function setReason($reason)
	{
		$this->reason = $reason;
	}

	/**
	 * Gets the reason of the warning
	 * 
	 * @return string the reason why the user is banned
	 */
	public function getReason()
	{
		return $this->reason;
	}

	/**
	 * Sets the date of the warning
	 * 
	 * @param integer $date the timestamp when the user was warned
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * Gets the date of the warning
	 * 
	 * @return integer the timestamp when the user was warned
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Sets the deleted status of the warning
	 * 
	 * @param boolean $deleted is the warning deleted?
	 */
	public function setDeleted($deleted)
	{
		$this->deleted = $deleted;
	}

	/**
	 * Gets the deleted status of the warning
	 * 
	 * @return boolean is the warning deleted?
	 */
	public function isDeleted()
	{
		return $this->deleted;
	}

}
