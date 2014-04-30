<?
require "classes/User.php";
$user=new UserAdmin();
$user->check_login($HTTP_COOKIE_VARS,"N");
if($action=="changepass"){
    $result=$user->change_password($HTTP_POST_VARS);
}
$fm=new FileManager();
?>
<HTML><HEAD><TITLE>Quinn's Quality Reporting, Ltd.</TITLE>
<script language=javascript type="text/javascript" src="js.js"></script>

<meta name="description" content="Quinn's Quality Reporting">
<meta name="keywords" content="Quinn's Quality Reporting">

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
      <A CLASS="title">Change Password</A> <BR><table cellpadding="3" cellspacing="0" border="0">
<form method="post" action="<?echo $PHP_SELF?>">
<input type="hidden" name="action" value="changepass">
<input type="hidden" name="returnpage" value="<?echo $returnpage?>">
<table cellpadding="3" cellspacing="0" border="0">
<?if($ID){?>
<input type="hidden" name="ID" value="<?echo $ID?>">
<?}
if($action=="changepass"){
?>
<tr>
	<td></td>
	<td><?echo $result?>
	<p><a href="<?echo $returnpage?>">Return</a>
	</td>
</tr>
<?}
if(($user->is_admin=="Y" && $ID==1)||($user->is_admin=="N" && $ID!=1)){
?>
<tr>
	<td CLASS="small">Old Password</td>
	<td><input type="password" name="oldpassword" SIZE="10"></td>
</tr>
<?}?>
<tr>
	<td CLASS="small">New Password</td>
	<td><input type="password" name="newpassword1" SIZE="10"></td>
</tr>
<tr>
    <td CLASS="small">Retype New Password</td>
    <td><input type="password" name="newpassword2" SIZE="10"></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" name="submit"></td>
</tr>
</table></TD>
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