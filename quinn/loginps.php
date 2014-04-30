<?php
require "classes/User.php";
if($HTTP_POST_VARS){
	$user=new UserAdmin($action,$HTTP_POST_VARS);
}
?>
