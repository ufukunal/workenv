<?php
echo "asdf";

mysql_connect("localhost","root","2882");
mysql_query("SET character_set_results = 'utf8', character_set_client = " .
		"'utf8', character_set_connection = 'utf8', character_set_database = " .
		"'utf8', character_set_server = 'utf8'");
mysql_select_db("face");/*
mysql_connect("deni2029.db.7658978.hostedresource.com","deni2029","De123456");
mysql_query("SET character_set_results = 'utf8', character_set_client = " .
		"'utf8', character_set_connection = 'utf8', character_set_database = " .
		"'utf8', character_set_server = 'utf8'");
mysql_select_db("deni2029");*/
class Config{

	public 	$appid="280547468668043";
	public $appsecret="9609a47a851470164985910067825f7c";

}

$config=new Config();

?>