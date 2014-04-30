<?
require "classes/User.php";
$user=new UserAdmin();
$user->check_login($HTTP_COOKIE_VARS,"Y");
if($action=="adduser"){
	$results=$user->add_user($HTTP_POST_VARS);
}
if($action=="addclient"){
	$results=$user->add_client($HTTP_POST_VARS);
}
if($action=="deletedoctor"){
	$results=$user->remove_client($_POST);
}
if($thisaction=="Delete"){
	if($ID!=1){
		$results=$user->remove_user($HTTP_POST_VARS);
	}else{
		print "<script language=\"javascript\">
			alert('You cannot remove this account');
			</script>";
	}
}
?>

<HTML><HEAD><TITLE>Quinn's Quality Reporting, Ltd.</TITLE>
<script language=javascript type="text/javascript" src="js.js"></script>

<meta name="description" content="Quinn's Quality Reporting">
<meta name="keywords" content="Quinn's Quality Reporting">

<script language="JavaScript">
function validForm(){
	var form=document.adduser;
	if(form.clientID.selectedIndex==0 || form.login_name.value=='' || form.password.value==''){
		alert ("You must fill in all fields");
		return false;
	}
	reg=/^[a-zA-Z0-9\s]+$/;
	if(!reg.test(form.client_name.value)){
		alert("Please only use letters or number in the client name");
		return false;
	}
	return true;
}
function validClientRemove(){
	var form=document.removeclient;
	if(form.clientID.selectedIndex==0){
		alert("Please select a Doctor\n");
		return false;
	}
	return true;
}
function validClientForm(){
    var form=document.addclient;
    if(form.client_name.value==''){
        alert ("Please enter a client name\n");
        return false;
    }
    reg=/^[a-zA-Z0-9\s]+$/;
    if(!reg.test(form.client_name.value)){
        alert("Please only use letters or number in the client name");
        return false;
    }
    return true;
}
</script>
</HEAD>
<BODY BGCOLOR="#660000" TEXT="#000000" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" LINK="#FF6600" VLINK="#FF6600" ALINK="#009933">



<TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="0">

	<TR>
		<TD WIDTH="20"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="20" HEIGHT="14" BORDER="0"></TD>
		<TD WIDTH="1"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="10"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="10" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="100%"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="440" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="10"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="10" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="1"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="2"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="2" HEIGHT="1" BORDER="0"></TD>
		<TD WIDTH="127"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="127" HEIGHT="1" BORDER="0"></TD>
	</TR>

	<TR>
		<TD COLSPAN="4"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="5" BORDER="0"><BR><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="9" HEIGHT="1" BORDER="0"><A HREF="http://www.quinnsreporting.com/"><IMG SRC="graphics/quinns_quality_reporting.gif" ALT="Quinn's Quality Reporting" WIDTH="312" HEIGHT="36" BORDER="0"></A></TD>
		<TD COLSPAN="3"></TD>
		<TD ROWSPAN="5"><IMG SRC="graphics/elephant.gif" ALT="Based in Omaha, NE" WIDTH="148" HEIGHT="149" BORDER="0"></TD>
	</TR>

	<TR>
		<TD ROWSPAN="4"></TD>
		<TD COLSPAN="4" BACKGROUND="graphics/n-right2.gif"><A HREF="http://www.quinnsreporting.com/"><IMG SRC="graphics/n-home_off.gif" ALT="" WIDTH="86" HEIGHT="26" BORDER="0"></A><IMG SRC="graphics/n-customers_on.gif" ALT="" WIDTH="85" HEIGHT="26" BORDER="0"><A HREF="http://www.quinnsreporting.com/services.htm"><IMG SRC="graphics/n-services_off2.gif" ALT="" WIDTH="85" HEIGHT="26" BORDER="0"></A><A HREF="http://www.quinnsreporting.com/schedule.htm"><IMG SRC="graphics/n-schedule_depo_off.gif" ALT="" WIDTH="85" HEIGHT="26" BORDER="0"></A><A HREF="http://www.quinnsreporting.com/contact.htm"><IMG SRC="graphics/n-contact_us_off.gif" ALT="" WIDTH="87" HEIGHT="26" BORDER="0"></A></TD>
		<TD COLSPAN="2"><IMG SRC="graphics/n-right.gif" ALT="" WIDTH="3" HEIGHT="26" BORDER="0"></TD>
	</TR>

	<TR>
		<TD BGCOLOR="#000000" ROWSPAN="3"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="1" BORDER="0"></TD>
		<TD ROWSPAN="3" BGCOLOR="#FFFFFF">&nbsp;</TD>
		<TD BGCOLOR="#FFFFFF">&nbsp;<BR>
      <A CLASS="title">Quinn's Add/Edit Users</A>
  <table border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td colspan="3"><form method="post" name="usermod" action="<?echo $PHP_SELF?>">
				<input type="hidden" name="returnpage" value="<?echo $PHP_SELF?>">
				<select name="ID" value="<?echo $row["ID"]?>">
				<option value="1">Quinn
	<?
	$user->client_display();
	while($row=$user->client_display_results()){
	?>
				<option value="<?echo $row["ID"]?>"><?echo $row["name"]." : ".$row["login_name"]?>
	<?}?>
				</select><br><br>
				<input type="submit" onClick="document.usermod.action='quinn_changepass.php';" value="Change Password">&nbsp;&nbsp;<input type="submit" name="thisaction" onClick="document.usermod.action='quinn_edit_users.php';" value="Delete"></form> 
			</td>
		</tr>
    <tr>
      <td CLASS="small">
        <div align="right"></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">&nbsp; </td>
    </tr>
	<tr>
		<td colspan="3">

		<?
		if($results=="dup"){
			print "<b>User or Client already exists</b>";
		}
		?>
		</td>
	</tr>
    <tr>
      <td CLASS="small">
		<form method="post" action="<?echo $PHP_SELF?>" name="addclient" onSubmit="return validClientForm()">
		<input type="hidden" name="action" value="addclient">
        <div align="right"><b>Add New Client Folder</b></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">&nbsp; </td>
    </tr>

    <tr>
      <td CLASS="small">
        <div align="right">Client Name</div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="text" name="client_name" SIZE="10">
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <div align="right"></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="submit" name="Submit" value="Add Folder"></form>
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <form method="post" action="<?echo $PHP_SELF?>" name="adduser" onSubmit="return validForm()">
        <input type="hidden" name="action" value="adduser">
        <div align="right"><b>Add New User</b></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">&nbsp; </td>
    </tr>
		<tr>
	  <td CLASS="small">
        <div align="right">Client Folder</div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
		<?$user->client_select()?>
      </td>
    </tr>
        <tr>
      <td CLASS="small">
        <div align="right">User Name</div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="text" name="login_name" SIZE="10">
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <div align="right">Password</div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="password" name="password" SIZE="10">
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <div align="right"></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="submit" name="Submit" value="Add User"></form>
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <form method="post" action="<?echo $PHP_SELF?>" name="removeclient" onSubmit="return validClientRemove()">
        <input type="hidden" name="action" value="deletedoctor">
        <div align="right"><b>Remove Client Folder</b></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">&nbsp; </td>
    </tr>

    <tr>
      <td CLASS="small">
        <div align="right">Client Name</div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
<?$user->client_select(true)?>
      </td>
    </tr>
    <tr>
      <td CLASS="small">
        <div align="right"></div>
      </td>
      <td width="2">&nbsp;</td>
      <td CLASS="small">
        <input type="submit" name="Submit" value="Remove Folder"></form>
      </td>
    </tr>
    	<tr>
      		<td>
        		<div align="right"></div>
      		</td>
      		<td width="2">&nbsp;</td>
      		<td>&nbsp; </td>
    	</tr>
    <tr>
      <td>
        <div align="right"></div>
      </td>
      <td width="2">&nbsp;</td>
      <td><a href="quinn_download.php" CLASS="smallnav2">&lt;&lt; Back</a></td>
    </tr>
  </table>
</TD>
		<TD ROWSPAN="3" BGCOLOR="#FFFFFF">&nbsp;</TD>
		<TD BGCOLOR="#000000" ROWSPAN="3"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="1" BORDER="0"></TD>
		<TD BGCOLOR="#FF9999" ROWSPAN="3"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="2" HEIGHT="1" BORDER="0"></TD>
	</TR>

	<TR>
		<TD BGCOLOR="#FFFFFF">&nbsp;</TD>
	</TR>

	<TR>
		<TD BGCOLOR="#FFFFFF" ALIGN="center"><A HREF="http://www.quinnsreporting.com/" CLASS="smallnav">Home</A><A CLASS="smallnavpipe"> | </A><A CLASS="smallnav2">Dictation</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/services.htm" CLASS="smallnav">Services</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/schedule.htm" CLASS="smallnav">Schedule Depo</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/contact.htm" CLASS="smallnav">Contact Us</A><BR>&nbsp;</TD>
	</TR>

	<TR>
		<TD ROWSPAN="2"></TD>
		<TD COLSPAN="6"><TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="0"><TR><TD BACKGROUND="graphics/bottom.gif"><IMG SRC="graphics/court_reporting.gif" ALT="" WIDTH="128" HEIGHT="27" BORDER="0"></TD><TD ALIGN="right" BACKGROUND="graphics/bottom.gif"><IMG SRC="graphics/transcriptions.gif" ALT="" WIDTH="130" HEIGHT="27" BORDER="0"></TD></TR></TABLE></TD>
		<TD ROWSPAN="2"></TD>
	</TR>

	<TR>
		<TD COLSPAN="6">&nbsp;<BR>&nbsp;</TD>
	</TR>

</TABLE>


</BODY>
</HTML>
