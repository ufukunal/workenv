<?php /*
mysql_connect("localhost","root","");
mysql_query("SET character_set_results = 'utf8', character_set_client = " .
		"'utf8', character_set_connection = 'utf8', character_set_database = " .
		"'utf8', character_set_server = 'utf8'");
mysql_select_db("face");

*/

mysql_connect("clicksem.db.8030767.hostedresource.com","clicksem","Shedower73");
mysql_query("SET character_set_results = 'utf8', character_set_client = " .
		"'utf8', character_set_connection = 'utf8', character_set_database = " .
		"'utf8', character_set_server = 'utf8'");
mysql_select_db("clicksem");

mysql_query("SET NAMES 'utf8'");
class Config{

	public 	$appid="";
	public $appsecret="";
	
	public $debug=true;

}

$config=new Config();
function myQuery($query){

	mysql_query($query) or die("<b>Veritabanı Hatası:</b>.\n<br />Query: " .
	$query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
}

function getInsert($table,$arr){

	//	var_dump($table);
	$sql="insert into $table(";

	foreach ($arr as $key => $value) {
		$sql.="$key,";
	}
	$sql=substr($sql,0,strlen($sql)-1).") values(";

	foreach ($arr as $key => $value) {
		$sql.="'$value',";
	}
	$sql=substr($sql,0,strlen($sql)-1).")";
	return $sql;
}
function getUpdate($table,$arr,$where){

	//	var_dump($table);
	$sql="update $table set ";

	foreach ($arr as $key => $value) {
		$sql.="$key='$value',";
	}
	

	$sql=substr($sql,0,strlen($sql)-1)." where $where";
	return $sql;
}
function selectOne($table,$field,$keyfield,$value,$debug=false) {

	$sql="select $field from $table where $keyfield=$value limit 1";
	if($debug)
	echo $sql;

	$res=mysql_query($sql) or die("<b>Veritabanı Hatası:</b>.\n<br />sorgu: " .
	$sql . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());;
	if($debug)
	print_r( $res);
	$row = mysql_fetch_assoc($res);

	return $row[$field];
}
function select($sql){
	$query=mysql_query($sql) or die("<b>Veritabanı Hatası:</b>.\n<br />sorgu: " .
	$sql . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
	$table=array();
	while($row=mysql_fetch_assoc($query)){
		$table[]=$row;
	}
	return $table;
}
?>