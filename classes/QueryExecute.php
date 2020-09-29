<?php
namespace Classes;

// This class is designed to execute query on database server.

class QueryExecute
{
	protected $dbLink;
	
	public function __construct()
	{
		$this->dbLink = mysqli_connect('localhost', 'id14929845_rangan_roy', 'A[Ut[!Z8bsZ(gQBV', 'id14929845_large22');
	}
	
	public function executeQuery($query)
	{
		if($result = mysqli_query($this->dbLink, $query))
		{
			return $result;
		}
		else die('Query Problem: '.mysqli_error($this->dbLink).'.');
	}
}
?>