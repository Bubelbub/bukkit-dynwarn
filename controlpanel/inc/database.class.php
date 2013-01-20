<?php

/**
 * The database class of the project. Could be mysql.
 *
 * @author Bubelbub <bubelbub@gmail.com>
 */
class Database
{

	/**
	 * @var MySQL the mysql link
	 */
	private $link;

	/**
	 * @var string the host of mysql server 
	 */
	private $host;

	/**
	 * @var integer the port of mysql server 
	 */
	private $port = 3306;

	/**
	 * @var string the username of mysql user 
	 */
	private $username;

	/**
	 * @var string the password of mysql user
	 */
	private $password;

	/**
	 * @var string the database to connect to
	 */
	private $database;

	/**
	 * Creates a database (not connected!)
	 * 
	 * @param string $host the host of mysql server
	 * @param string $username the username of mysql user
	 * @param string $password the password of mysql user
	 * @param string $database the database to connect to
	 * @param integer $port the port of the mysql server
	 */
	public function __construct($host, $username, $password, $database, $port = 3306)
	{
		$this->setHost($host);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setDatabase($database);
		$this->setPort($port);
	}

	/**
	 * Connects to the mysql server and selects the database
	 * 
	 * @return boolean true = connected; false = not connected
	 * @throws Exception if the connect fails the errors of the mysql server
	 */
	public function connect()
	{
		if (!$this->link = mysql_connect($this->getHost() . ':' . $this->getPort(), $this->getUsername(), $this->getPassword(), true))
		{
			throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
		}
		if (!mysql_select_db($this->getDatabase()))
		{
			throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
		}
		return true;
	}

	/**
	 * Gets the mysql link identifier
	 * 
	 * @return MySQL the mysql link identifier
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * Sets the host of the database connection
	 * 
	 * @param string $host the host of the database connection
	 */
	public function setHost($host)
	{
		$this->host = $host;
	}

	/**
	 * Gets the host of the database connection
	 * 
	 * @return string the host of the database connection
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * Sets the port of the database connection
	 * 
	 * @param integer $port the port of the database connection
	 */
	public function setPort($port)
	{
		$this->port = $port;
	}

	/**
	 * Gets the port of the database connection
	 * 
	 * @return integer the port of the database connection
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * Sets the username of the database connection user
	 * 
	 * @param string $username the username of the database connection user
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * Gets the username of the database connection user
	 * 
	 * @return string the username of the database connection user
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Sets the password of the database connection user
	 * 
	 * @param string $password the password of the database connection user
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * Gets the password of the database connection user
	 * 
	 * @return string the password of the database connection user
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Sets the database of the database connection
	 * 
	 * @param string $database the database of the database connection
	 */
	public function setDatabase($database)
	{
		$this->database = $database;
	}

	/**
	 * Gets the database of the database connection
	 * 
	 * @return string the database of the database connection
	 */
	public function getDatabase()
	{
		return $this->database;
	}

	/**
	 * Disconnects from mysql server
	 * 
	 * @throws Exception if the disconnect fails the errors of the mysql server
	 */
	public function __destruct()
	{
		if ($this->getLink() != null)
		{
			if (!mysql_close($this->getLink()))
			{
				throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
			}
		}
	}

	/**
	 * Loads entries from database
	 * 
	 * @param string $table the table from which the data are to be loaded
	 * @param array $where optional the where array
	 * @param array $order optional the order array
	 * @param integer $limit optional the limit
	 * @return array the entries
	 * @throws Exception if there is a error with the result
	 */
	public function getEntries($table, $where = array(), $order = array(), $limit = null)
	{
		$sql = 'SELECT * FROM `' . $table . '`';
		if (count($where > 0))
		{
			$sql .= ' WHERE ' . implode(' AND ', $where);
		}
		if (count($order > 0))
		{
			$sql .= ' ORDER BY ' . implode(', ', $order);
		}
		if ($limit != null)
		{
			$sql .= ' LIMIT ' . $limit;
		}
		$sql .= ';';

		$result = mysql_query($sql, $this->getLink());
		if (!$result)
		{
			throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
		}

		$entries = array();
		if (mysql_num_rows($result) > 0)
		{
			while ($row = mysql_fetch_assoc($result))
			{
				$entries[] = $row;
			}
		}

		return $entries;
	}

	/**
	 * Load a single entry from the $table with $id
	 * 
	 * @param string $table the table from which the data are to be loaded
	 * @param integer $id the id which item should be selected
	 * @return null|array with entry data
	 */
	public function getEntry($table, $id)
	{
		$item = $this->getEntries($table, array('id' => $id), array(), 1);
		if (count($item) < 1)
		{
			return null;
		}
		else
		{
			return $item[0];
		}
	}

	/**
	 * Saves/Creates a entry to the database (like persist)
	 * 
	 * @param string $table the table from which the data are to be loaded
	 * @param integer $id the id which item should be selected
	 * @param array $updateArray the array with the key/values to update/insert
	 * @return boolean true if the entry is saved else false
	 * @throws Exception if there is a error with the result
	 */
	public function saveEntry($table, $id, $updateArray)
	{
		foreach ($updateArray as $key => $value)
		{
			$updateArray[$key] = $this->escape($value);
		}

		if ($id > 0)
		{
			$sql = 'UPDATE `' . $table . '`';
			if (count($updateArray) > 0)
			{
				$sql .= ' SET ';
				$first = true;
				foreach ($updateArray as $key => $value)
				{
					$sql .= ($first ? $first	 = false : ', ') . '`' . $key . '` = ' . $value;
				}
			}
			$sql .= ' WHERE `id` = ' . $id;
			$sql .= ' LIMIT 1;';
			$result	 = mysql_query($sql);
			if (!$result)
			{
				throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
			}
			return true;
		}
		else
		{
			$sql	 = 'INSER INTO `' . $table . '` (`' . implode('`, `', array_keys($updateArray)) . '`)';
			$sql .= " VALUES ('" . implode("', '", $updateArray) . "');";
			$result	 = mysql_query($sql, $this->getLink());
			if (!$result)
			{
				throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
			}
			return true;
		}
	}

	/**
	 * Escape a value for mysql
	 * 
	 * @param string $value the value to escape
	 * @return string the escaped string
	 */
	public function escape($value)
	{
		return mysql_real_escape_string($value, $this->getLink());
	}

	/**
	 * Deletes a entry from the database
	 * 
	 * @param string $table the table from which the data are to be loaded
	 * @param integer $id the id which item should be deleted
	 * @return boolean true if the entry is saved else false
	 * @throws Exception if there is a error with the result
	 */
	public function deleteEntry($table, $id)
	{
		$sql = 'DELETE FROM `' . $table . '`';
		$sql .= ' WHERE `id` = ' . (int) $id;
		$sql .= ' LIMIT 1;';

		$result = mysql_query($sql, $this->getLink());
		if (!$result)
		{
			throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
		}

		return true;
	}

	/**
	 * Returns the sum of entries from $table with $where
	 * 
	 * @param string $table the table from which the data are to be loaded
	 * @param array $where optional the where array
	 * @return integer the count of rows
	 * @throws Exception if there is a error with the result
	 */
	public function countEntries($table, $where=array())
	{
		$sql = 'SELECT COUNT(0) AS `rows` FROM `' . $table . '`';
		if (count($where > 0))
		{
			$sql .= ' WHERE ' . implode(' AND ', $where);
		}
		$sql .= ' LIMIT 1;';

		$result = mysql_query($sql, $this->getLink());
		if (!$result)
		{
			throw new Exception('[' . mysql_errno($this->getLink()) . '] ' . mysql_error($this->getLink()));
		}

		$data = mysql_fetch_assoc($result);

		return key_exists('rows', $data) ? $data['rows'] : 0;
	}

}
