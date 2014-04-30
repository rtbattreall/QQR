<?php
require "/var/www/vhosts/quinnsreporting.com/httpsdocs/classes/DB.php";
require "/var/www/vhosts/quinnsreporting.com/httpsdocs/classes/FileManager.php";
class UserAdmin
{
	var $formdata;
	var $login_name;
	var $password;
	var $ID;
	var $CID;
	var $md5_password;
	//Defined actions are:
	//login
	//changepassword
	//adduser - can only be performed if user in administrator
	var $action;
	var $is_admin;
	var $cookie_name; //cookie has to move around...
	var $cookie_value;
	var $login_page;
	var $admin_page="quinn_download.php";
	var $client_page="client_upload.php";
	var $page; //will be assigned either admin_page, or client_page, depending on login
	var $db;
	var $hold_directory;
	var $client_name;

	function UserAdmin($action="0",$formdata="0"){
		$this->db=new DB("QuinnFM");
        $this->login_page="https://www.quinnsreporting.com/index.php";
		$this->cookie_name="Quinn";
	//	$this->formdata=$formdata;
		$this->action=$action;
		//This first thing will always to be to login..
		if($this->action=="login"){
			$this->login_name=$formdata['login_name'];
			$this->password=$formdata['password'];
			//$this->action=$this->formdata['action'];
			$this->login($this->login_name,$this->password,$this->page);
		}
		if($this->action=="logout"){
			$this->logout();
		}
	}
	function login($login_name,$password,$page){
		//Check username, password combo.
		//Set is_admin (Y,N)
		//Set cookie so we can follow from page to page.
		//If successful login, send to $page.
		$this->login_name=$login_name;
		$this->password=$password;
		$this->md5_password=md5($password);
		$this->db->set_query("select type from users where login_name='$this->login_name' and password='$this->md5_password'");
		//print $this->db->get_query();
		$this->db->execute_query();
		$num_results=$this->db->number_results();
		//print "num_results = $num_results<br>";
		if(!($num_results)){
			//$successpage=$this->login_page."?success=0";
			header("Location: $this->login_page?success=fail");
			exit;
			//$this->print_status("Failed Login");
		}
	
		$results=$this->db->get_results("assoc");
		if($results['type']=="A"){
			$this->is_admin='Y';
			$this->page=$this->admin_page;
		}else{
			$this->is_admin='N';
			$this->page=$this->client_page;
		}
		$this->cookie_value="$this->login_name:$this->md5_password";
		//Lets set the cookie...
		$this->set_cookie();
		//The cookie is not set.  Redirect to the next page
		header("Location: $this->page");
	}
	function logout(){
		$this->clear_cookie();
		header("Location: $this->login_page");
	}
	function set_cookie(){
		//This will expire after the browser is closed.
		setcookie($this->cookie_name,$this->cookie_value);
	}
	function clear_cookie(){
		setcookie($this->cookie_name,"");
	}
	function check_login($cookies,$admin){
		//When called, must specify if this is admin or not.  So clients can't get to
		//the admin pages.
		$val=$cookies[$this->cookie_name];
		$valarr=split(":",$val);
		//login_name and md5 password is stored in the cookie
		$login_name=$valarr[0];
		$password=$valarr[1]; //Actually the md5 password
		$this->db->set_query("select type,ID,CID from users where login_name='$login_name' and password='$password'");
		$this->db->execute_query();
		if($this->db->number_results()==0){
			//If they aren't logged in, return them to the login page
			header("Location: $this->login_page");
		}
		$results=$this->db->get_results("assoc");
		$this->ID=$results["ID"];
		$this->CID=$results["CID"];

		if($results["type"]=="C"){
			if($admin=="Y"){
				print "You must be authorized to access this page<br>";
				exit;
			}
			//We need to set the hold directory now..
			$this->db->set_query("select a.hold_directory,a.name from client a, users b where b.ID=".$results["ID"]." and a.ID=b.CID");
			$this->db->execute_query();
			$sethold=$this->db->get_results("num");
			$this->hold_directory=$sethold[0];
			//print "hold dir is ".$this->hold_directory."<br>";
			$this->client_name=$sethold[1];
			$this->is_admin="N";
		}else if($results["type"]=="A"){
			$this->is_admin="Y";
		}
	}
	function get_ID(){
		return $this->ID;
	}
	function get_CID(){
		return $this->CID;
	}
	function get_hold_dir($clientID="NULL"){
		if($clientID=="NULL"){
			return $this->hold_directory;
		}
		$this->db->set_query("select hold_directory from client where ID=$clientID");
		$this->db->execute_query();
		$result=$this->db->get_results("num");
		return $result[0];
	}
	function download_file($clientID,$fileID,$fileName){
		$client_name=$this->get_client_name($clientID);
		$fm=new FileManager($client_name);
		$fm->download_file($fileName,$this->get_hold_dir($clientID),$this->ID,$fileID);
	}
	//function get_client_name(){
	//	return $this->client_name;
	//}
	function get_client_name($clientID="NULL"){
		if($clientID=="NULL"){
			return $this->client_name;
		}
		$this->db->set_query("select a.name from client a, users b where a.ID=$clientID and a.ID=b.CID");
		$this->db->execute_query();
		$result=$this->db->get_results("num");
		return $result[0];
	}
	function get_file_data($clientID){
		$this->db->set_query("select ID,file_name,file_size,date_format(upload_date,'%M %D, %Y %l:%i%p') as upload_date,mime_type,status,CID,comments from upload_tracking where CID=$clientID order by file_name");
		$this->db->execute_query();
	}
	function get_file_data_results(){
		return $this->db->get_results("assoc");

	}
	function add_user($formdata){
		if($this->is_admin=="N"){
			print "You do not have permission to preform this function<br>";
			exit;
		}
		//We are creating a directory name the client name minus spaces.
		//We are only allowing letters and numbers in the name
		/*if(!(preg_match("/^[a-zA-Z0-9\s]+$/",$formdata["client_name"]))){
			print "<p><b>ALERT: Bad Client Name!</b></p>";
			print "The client name can only have letters and numbers. Go <a href=\"javascript: history.back()\">back</a> and try again";
		}*/
		//Pull the data from the form
		$login_name=addslashes($formdata["login_name"]);
		$password=md5($formdata["password"]);
		$clientID=addslashes($formdata["clientID"]);
		//First, lets see if the user already exists.
		$this->db->set_query("select * from users  where login_name='$login_name'");
		$this->db->execute_query();
		if($this->db->number_results()>0){
			return "dup";
		}
		//Add the username, password, and client name.  Create the hold directory for the
		//file uploads
		$this->db->set_query("insert into users(CID,login_name,password,type) values($clientID,'$login_name','$password','C')");
		$this->db->execute_query();
		//calculate hold directory
		/*$fm=new FileManager($client_name);
		$holddir=$fm->generate_hold_dir();
		$lastID=$this->db->last_ID();
		$this->db->set_query("insert into client(UID,name,hold_directory) values($lastID,'$client_name','$holddir')");
		$this->db->execute_query();
		//Lets actuall create the hold directory
		$fm->create_hold_dir();
		*/
		//Success!
		$added["clientID"]=$clientID;
		$added["login_name"]=$login_name;
		return $added;
	}
	function add_client($formdata){
        if($this->is_admin=="N"){
            print "You do not have permission to preform this function<br>";
            exit;
        }
        //We are creating a directory name the client name minus spaces.
        //We are only allowing letters and numbers in the name
        if(!(preg_match("/^[a-zA-Z0-9\s]+$/",$formdata["client_name"]))){
            print "<p><b>ALERT: Bad Client Name!</b></p>";
            print "The client name can only have letters and numbers. Go <a href=\"javascript: history.back()\">back</a> and try again";
        }
		$client_name=addslashes($formdata["client_name"]);
        $this->db->set_query("select * from client where name='$client_name'");
        $this->db->execute_query();
        if($this->db->number_results()>0){
            return "dup";
        }

        //file uploads
        //calculate hold directory
        $fm=new FileManager($client_name);
        $holddir=$fm->generate_hold_dir();
        $this->db->set_query("insert into client(name,hold_directory) values('$client_name','$holddir')");
        $this->db->execute_query();
        //Lets actuall create the hold directory
        $fm->create_hold_dir();
        //Success!
        $added=$client_name;
        return $added;
	}
	function remove_user($formdata){
		if($this->is_admin=="N"){
            print "You do not have permission to preform this function<br>";
            exit;
        }

		$ID=$formdata["ID"];

		//remove directories and contents.
		//Get the hold directory and the client name
		/*$this->db->set_query("select name,hold_directory from client where UID=$ID");
		$this->db->execute_query();
		$result=$this->db->get_results("num");
		$fm=new FileManager($result[0]);
		$fm->remove_client_dir();
		//remove from database.
		*/
		//Delete from users
		$this->db->set_query("delete from users where ID=$ID");
		$this->db->execute_query();
		//Delete from client
		/*
		$this->db->set_query("delete from client where UID=$ID");
		$this->db->execute_query();
		//Delete from upload_tracking
		$this->db->set_query("delete from upload_tracking where UID=$ID");
		$this->db->execute_query();
		*/
	}
	function remove_client($formdata){
		if($this->is_admin=="N"){
            print "You do not have permission to preform this function<br>";
        	exit;
        }
		$ID=$formdata["clientID"];
		
      //remove directories and contents.
        //Get the hold directory and the client name
        $this->db->set_query("select name,hold_directory from client where ID=$ID");
        $this->db->execute_query();
        $result=$this->db->get_results("num");
        $fm=new FileManager($result[0]);
        $fm->remove_client_dir();
        //remove from database.
        
        //Delete from users
        $this->db->set_query("delete from users where CID=$ID");
        $this->db->execute_query();
        //Delete from client
        
        $this->db->set_query("delete from client where ID=$ID");
        $this->db->execute_query();
        //Delete from upload_tracking
        $this->db->set_query("delete from upload_tracking where CID=$ID");
        $this->db->execute_query();
        
		
	}
	function client_display(){
		if($this->is_admin!="Y"){
            print "You do not have permission to preform this function<br>";
            exit;
        }
		$this->db->set_query("select a.ID,a.login_name,b.name from users a,client b where a.CID=b.ID");
		$this->db->execute_query();
	}
	function client_display_results(){
		return $this->db->get_results("assoc");
	}
	function client_select($submit=false){
		if($this->is_admin=="N"){
			print "You are not authorized to access this function<br>";
			exit;
		}
		if($submit){
			$onChange="onChange=\"submitForm()\"";
		}
		$this->db->set_query("select ID, name from client order by name");
		$this->db->execute_query();
		print "<select name=\"clientID\" $onChange><option value=\"0\">-- Select Client --\n";
		while($row=$this->db->get_results("num")){
			print "<option value=\"$row[0]\">$row[1]";
		}
		print "</select>";
	}
	function change_password($formdata){
		if($formdata["newpassword1"] != $formdata["newpassword2"]){
			return "The new password does not match the retyped password";
		}else{
			//If this is an administrator, they can change anyone's password.
			if($this->is_admin=="Y" && $formdata["ID"]!=1){
				$this->db->set_query("update users set password='".md5($formdata["newpassword1"])."' where ID=".$formdata["ID"]);
				$this->db->execute_query();
				return "Password has been succussfully updated";
			}else{
			//We will check to make sure their id is equal to the one passed in the form.
			//Maybe I'm being a bit paranoid :-)
			//Cookie will have to be re-set.
				if($this->ID!=$formdata["ID"]){
					return "You do not have authorization to perform this action";
				}else{
					$this->db->set_query("select ID,login_name from users where ID=$this->ID and password='".md5($formdata["oldpassword"])."'");
					$this->db->execute_query();
					if($this->db->number_results()<1){
						//wrong password
						return "Your password did not match.  Please try again.";
					}else{
						$row=$this->db->get_results("assoc");
						$this->login_name=$row["login_name"];
						//It matched, lets update the password
						$this->db->set_query("update users set password='".md5($formdata["newpassword1"])."' where ID=".$formdata["ID"]);
						$this->md5_password=md5($formdata["newpassword1"]);
						$this->cookie_value=$this->login_name.":".$this->md5_password;
						$this->set_cookie();
						$this->db->execute_query();	
						return "Your password has successfully been changed";
					}
				}
			}
		}
	}
	function get_recent_uploads(){
		$this->db->set_query("select a.ID,a.name,b.file_name,b.file_size,b.ID as fileID,comments,status,date_format(upload_date,'%M %D, %Y %l:%i%p') as udate from client a, upload_tracking b where (to_days(NOW()) - to_days(upload_date)) <= 4 and a.ID=b.CID order by a.name limit 20");
		$this->db->execute_query();
	}
	function get_recent_results(){
		return $this->db->get_results("assoc");
	}
	function print_status($type){
		if($type=="Failed Login"){
			print "<b>Login Failed</b><p><a href=\"javascript:history.back()\">Try again</a></p>";
			exit;
		}
		if($type=="DupUser"){
			print "<p><b>There is already a client or user with that client name or user name.</b></p>";
			//exit;
		}
	}
}
?>
