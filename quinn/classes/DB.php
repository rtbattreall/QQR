<?php
$fullpath="/var/www/vhosts/quinnsreporting.com/httpsdocs";
require "$fullpath/incl/dbconnect.php";
class DB{
	var $link;
	var $res;
	var $sql;
	var $user;
	var $pass;
	var $dbname;

	function DB($db){
		global $DBuser, $DBpass;
		$this->dbname=$db;
		$this->link=mysql_connect($host,$DBuser,$DBpass) 
			or die ("Could not connect, try_it later");
		mysql_select_db($this->dbname,$this->link)
			or die("Could not select $this->dbname");
	}
	function set_query($sql){
		//print "$sql<br>";
		$this->sql=$sql;
	}
	function get_query(){
		//For Debug purposes
		return $this->sql;
	}
	function execute_query(){
		$this->try_it($this->sql,"SQL");
		if(!$this->res=mysql_query($this->sql,$this->link)){
			print "Could not execute $this->sql<br>";
			exit;
		}
	}
	function get_results($type){
		//Type is one of either:
		//assoc=associative array
		//num=numberically indexed array
		//both=both types of arrays are returned.
		$this->try_it($this->res,"result");		
		if($type=="assoc"){
			$arrtype=MYSQL_ASSOC;
		}else if($type=="num"){
			$arrtype=MYSQL_NUM;
		}else if($type=="both"){
			$arrtype=MYSQL_BOTH;
		}
			
		return mysql_fetch_array($this->res,$arrtype);
	}
	function number_results(){
       	$this->try_it($this->res,"result");
		
		$rows= mysql_num_rows($this->res);
//		print "rows = $rows<br>";
		return $rows;
	}
	function last_ID(){
		return mysql_insert_id($this->link);
	}
	function try_it($in,$display){
		//This is to make sure the precedence is set 
		//$in is the field
		//$display is what you want displayed to the user that should be set.
		if(!$in){
			print "<b>ERROR:</b> Please set $display beore continuing<br>";
			exit;
		}
		
	}
}
?>
