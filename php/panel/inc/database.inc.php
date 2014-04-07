<?php

class Database
{
    // Connection parameters
	
	var $host = "";
    var $user = "";
    var $password = "";
    var $database = "";

    var $persistent = false;

	// Database connection handle 
    var $conn = NULL;

    // Query result 
    var $result = false;

//    function DB($host, $user, $password, $database, $persistent = false)
    function Database()
    {
		$config = new Config();

		$this->host = $config->host;
		$this->user = $config->user;
		$this->password = $config->password;
		$this->database = $config->database;
   	
	}

    function open()
    {
        // Choose the appropriate connect function 
        if ($this->persistent) {
            $func = 'mysql_pconnect';
        } else {
            $func = 'mysql_connect';
        }

        // Connect to the MySQL server 
        $this->conn = $func($this->host, $this->user, $this->password);
		
        if (!$this->conn) {
		//header("Location: error.html");
		echo mysql_error();
	    exit;
            return false;
        }

		@mysql_query("SET NAMES 'utf8' COLLATE 'utf8_bin'");  
        // Select the requested database 
        if (!@mysql_select_db($this->database, $this->conn)) {
            return false;
        }

        return true;
    }

    function close()
    {
        return (@mysql_close($this->conn));
    }

    function error()
    {
        return (mysql_error());
    }

    function query($sql = '')
    {
        $this->result = @mysql_query($sql, $this->conn);
		return ($this->result != false);
    }

    function affectedRows()
    {
        return (@mysql_affected_rows($this->conn));
    }

    function numRows()
    {
        return (@mysql_num_rows($this->result));
    }

    function numCols()
    {
        return @mysql_num_fields($this->result);
    }
	
	function fieldName($field)
    {
       return (@mysql_field_name($this->result,$field));
    }
	 function insertID()
    {
        return (@mysql_insert_id($this->conn));
    }
    
    function fetchObject()
    {
        return (@mysql_fetch_object($this->result, MYSQL_ASSOC));
    }

    function fetchArray()
    {
        return (@mysql_fetch_array($this->result, MYSQL_BOTH));
    }

    function fetchAssoc()
    {
        return (@mysql_fetch_assoc($this->result));
    }

    function freeResult()
    {
        return (@mysql_free_result($this->result));
    }
}
?>
