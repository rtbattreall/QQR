<?
//Check if user has access, (cookied)
require "classes/User.php";
$user=new UserAdmin();
$user->check_login($HTTP_COOKIE_VARS,"N");
$fm=new FileManager($user->get_client_name());
$clientID=$user->get_CID();
    $clientname=$user->get_client_name($clientID);
if($action=="attach"){
	if($HTTP_POST_FILES){
		$result=$fm->upload_file($user->get_CID(),$HTTP_POST_VARS,$HTTP_POST_FILES,$user->get_hold_dir());
	}
}
if($action=="download"){

    $user->download_file($clientID,$fileID,$filename);
    exit;

}
if($action=="updatestatus"){
	$fm->update_status($_POST);
}
if($action=="delete"){
	$fm->delete_file($fileID,$filename,$user->get_hold_dir());
}
?>
<HTML><HEAD><TITLE>Quinn's Quality Reporting, Ltd.</TITLE>
<script language=javascript type="text/javascript" src="js.js"></script>

<meta name="description" content="Quinn's Quality Reporting">
<meta name="keywords" content="Quinn's Quality Reporting">

<script language="javascript" type="text/javascript">
function confirmDelete(){
	return confirm("Delete File?");
}
function showUpload(id){
	/*if(document.all){
		document.all.up.style.display="inline";
	}else if(document.getElementByID){
		document.getElementByID("up").style.display="inline";
	}*/
    if(document.all){
        document.all[id].style.visibility="visible";
    }else if(document.getElementByID){
        document.getElementByID(id).style.visibility=visible;

    }

		
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
      <A CLASS="title">Upload/Download Files for <?echo $clientname?></A> <BR><form name="upload" method="post" action="<?echo $base.$PHP_SELF?>" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="3">
	<?if($result){?>
	<tr>
		<td></td>
		<td></td>
		<td class="small">INVALID FILE<br>Make sure the file name does not contain any non alpha-numeric characters such as "&amp;","?", etc.</td>
	</tr>
	<?}?>
    <tr>
      <td>
        <div align="right" CLASS="small">Attach File</div>
      </td>
      <td width="2">&nbsp;</td>
      <td>
			<input type="file" name="uploadedfile" SIZE="15">
      </td>
    </tr>
    <tr>
      <td>
        <div align="right" CLASS="small">Comments</div>
      </td>
      <td width="2">&nbsp;</td>
      <td>
			<textarea name="comments" cols="30" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td valign="top">
		<input type="hidden" name="action" value="attach">
        <div align="right" CLASS="small">Status</div>
      </td>
      <td width="2">&nbsp;</td>
      <td>
        <input type="text" NAME="status" ROWS="4">
		<br><br>
		<table cellpadding="3" cellspacing="0">
		<tr>
			<td><input type="submit" name="submit" value=" Send " onClick="showUpload('up')">  <?
    if(eregi("msie",$HTTP_USER_AGENT) || eregi("mozilla/5.0",$HTTP_USER_AGENT)){?><span id="up" style="visibility:hidden"><span class="smallnav2">Loading &#150; large files 
may take a while &#150; please be patient</span></span><?}?></td>
			<td><!--<input type="reset" value=" Reset ">--></td>
		</tr>
		</table>
		</form>
      </td>
    </tr>
	<tr>
		<td colspan="3"><p>&nbsp;</p></td>
	</tr>
	<tr>
      <td colspan="3">
		<table cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td><b CLASS="small">Attached File(s)</b></td>
			<td></td>
		</tr>
		<tr>
			<td><b CLASS="small">File Name</b></td>
			<td><b CLASS="small">Upload Date</b></td>
			<td><b CLASS="small">File Size</b></td>
			<td><b class="small">Status</b></td>
			<td></td>
			<td></td>
		</tr>
		<?
		$user->get_file_data($clientID);
    		while($row=$user->get_file_data_results()){?>

		<tr>
			<td valign="top" CLASS="small"><a CLASS="smallnav8" href="<?echo $PHP_SELF?>?clientID=<?echo $row["CID"]?>&action=download&filename=<?echo $row["file_name"]?>&fileID=<?echo $row["ID"]?>"><?echo $row["file_name"]?></a></td>
			<td valign="top" class="small"><?=$row["upload_date"]?></td>
			<td valign="top" CLASS="small" CLASS="smallnav"><? echo $fm->format_size($row["file_size"])?></td>
			<td valign="top"><form method="post" action="<?echo $PHP_SELF?>"><textarea cols="25" rows="3" name="status"><?echo stripslashes($row["status"])?></textarea></td>
			<td valign="top"><input type="hidden" name="action" value="updatestatus"><input type="hidden" name="fileID" value="<?echo $row["ID"]?>"><input type="submit" value="Update Status"></form></td>
			<td valign="top"><form method="post" action="<?echo $PHP_SELF?>" onSubmit="return confirmDelete()">
			<input type="hidden" name="fileID" value="<?echo $row["ID"]?>">
			<input type="hidden" name="filename" value="<?echo $row["file_name"]?>">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Delete">
			</td>
		</tr>
		<tr>
			<td COLSPAN="2"></td>
			<td COLSPAN="3" CLASS="small"><i>Comments</i><br><?echo stripslashes($row["comments"])?><BR>&nbsp;<BR>&nbsp;</td>
		</tr>
			</form>
		<?}?>
		</table></TD></tr>
		</table></TD>
		<TD ROWSPAN="3" BGCOLOR="#FFFFFF">&nbsp;</TD>
		<TD BGCOLOR="#000000" ROWSPAN="3"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="1" HEIGHT="1" BORDER="0"></TD>
		<TD BGCOLOR="#FF9999" ROWSPAN="3"><IMG SRC="graphics/spacer.gif" ALT="" WIDTH="2" HEIGHT="1" BORDER="0"></TD>
	</TR>

	<TR>
		<TD BGCOLOR="#FFFFFF">&nbsp;<BR><TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0"><TR><TD><form method="post" action="loginps.php"><input type="hidden" name="action" value="logout"><input type="submit" ALT="" WIDTH="56" HEIGHT="21" BORDER="0" VSPACE="3" VALUE="Log Out"></form></TD><TD><form method="post" action="quinn_changepass.php">
			<input type="hidden" name="ID" value="<?echo $user->ID?>">
			<input type="hidden" name="returnpage" value="<?echo $PHP_SELF?>">
			<INPUT TYPE="submit" VALUE="Change Password"></form></TD></TR></TABLE><BR>&nbsp;</TD>
	</TR>

	<TR>
		<TD BGCOLOR="#FFFFFF" ALIGN="center"><A HREF="http://www.quinnsreporting.com/" CLASS="smallnav">Home</A><A CLASS="smallnavpipe"> | </A><A CLASS="smallnav2">Customers</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/services.htm" CLASS="smallnav">Services</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/schedule.htm" CLASS="smallnav">Schedule Depo</A><A CLASS="smallnavpipe"> | </A><A HREF="http://www.quinnsreporting.com/contact.htm" CLASS="smallnav">Contact Us</A><BR>&nbsp;</TD>
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
