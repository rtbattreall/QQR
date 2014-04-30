<?
//require "DB.php":
class FileManager{
	var	$login_name;
	var $client_name;
	var $hold_directory;
	var $root_dir;
	var $client_dir;
	var $db;

	function FileManager($client_name="Null"){
		if($client_name!="Null"){
			$this->db=new DB("QuinnFM");
			$this->client_name=ereg_replace(" ","",$client_name);
			$this->root_dir="/var/www/vhosts/quinnsreporting.com/httpsdocs/clients";
			$this->client_dir=$this->root_dir."/".$this->client_name;
		}
	}
	function generate_hold_dir(){
		$length=rand(10,16);
   		$all = explode( " ",
          "a b c d e f g h i j k l m n o p q r s t u v w x y z "
        . "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z "
                 . "0 1 2 3 4 5 6 7 8 9");

    	for($i=0;$i<$length;$i++) {
        	srand((double)microtime()*1000000);
			$randy = rand(0, 61);
			$holddir .= $all[$randy];
    	}
		$this->hold_directory=$this->client_dir."/".$holddir;
		return $this->hold_directory;
	}
	function create_hold_dir(){
		//client_name/hold_directory
		//first make client directory
		mkdir($this->client_dir,0777)
			or die("Could not make $this->client_dir");
		mkdir($this->hold_directory,0777)
			or die("Could not make hold directory");

	}
	function remove_client_dir(){
		//Remove the client directory
		$cmd="rm -rf $this->client_dir";
		`$cmd`;
	}
	function upload_file($CID,$formdata,$filedata,$holddir){
		//find out where it goes, according to the id...
		if($filedata['uploadedfile']['name']){
			if(preg_match("/&/",$filedata['uploadedfile']['name'])){
				return 1;
			}
			$filedata['uploadedfile']['name'] = str_replace("%","",$filedata['uploadedfile']['name']);
			$filename=addslashes($filedata['uploadedfile']['name']);
			$filesize=$filedata['uploadedfile']['size'];
			if($filesize==0 || preg_match("/[`\"';]/",$filename)){
				return 1;
			}
			
			$status=$formdata['status'];
			$status=preg_replace("/>|<|\"|\\\/","",$status);
			$status=addslashes($status);
			$comments=$formdata['comments'];
			$comments=preg_replace("/>|<|\"|\\\/","",$comments);
			$comments=addslashes($comments);
			$fullpathtofile=$holddir."/".$filedata['uploadedfile']['name'];
            //We need to see if the file already exists. If it does, it will be removed
            //and the new copy will be uploaded
			$this->db->set_query("select count(*) from upload_tracking where file_name='".addslashes($filename)."' and CID=$CID");
            $this->db->execute_query();
            $row=$this->db->get_results("num");

            if($row[0]>0){
                //get the fileiD
                $this->db->set_query("select ID from upload_tracking where file_name='".addslashes($filename)."' and CID=$CID");
				$this->db->execute_query();
                $row=$this->db->get_results("num");
                $fileID=$row[0];
                //remove the file
                $this->delete_file($fileID,$filename,$holddir);
            }

			move_uploaded_file($filedata['uploadedfile']['tmp_name'],$holddir."/".$filedata['uploadedfile']['name']);
			//Lets see if we can get teh mime type
			$filetype=$this->get_mime_type($fullpathtofile);
			//The files are up. Now lets place it in the database.
			$this->db=new DB("QuinnFM");
			$this->db->set_query("insert into upload_tracking(
				CID,
				file_name,
				file_size,
				mime_type,
				upload_date,
				status,
				comments)
				values (
				$CID,
				'$filename',
				$filesize,
				'$filetype',
				now(),
				'$status',
				'$comments')
				");
			
			$this->db->execute_query();
			//If file is uploaded, notify Vicki
			//Get Client Name
			$client_name=UserAdmin::get_client_name($CID);
			//Set temporary From
			$temp_from="From: \"Dictation Web Application\" <info@quinnsreporting.com>";
			//mail("andre@eleven19.com","Upload for $client_name","","$temp_from");
			mail("info@quinnsreporting.com","Upload for $client_name","","$temp_from");
		}
	}
	function delete_file($fileID,$filename,$holddir){
		//Remove from upload_tracking
		$this->db->set_query("delete from upload_tracking where ID=$fileID");
		$this->db->execute_query();
		//Remove from download_tracking
        $this->db->set_query("delete from download_tracking where FID=$fileID");
        $this->db->execute_query();
		//now lets remove the file
		unlink($holddir."/".$filename);
	}
	function download_file($fileName,$holddir,$UID,$FID){
		$fullpathtofile=$holddir."/".$fileName;
		$mimetype=$this->get_mime_type($fullpathtofile);
    	$fp = fopen ($fullpathtofile, "r");
    	header("Content-type: $mimetype");
    	header("Content-Disposition: attachment; filename=$fileName");
    	fpassthru($fp);
		//Assume it was successful.  Let's log it.
		$this->db->set_query("insert into download_tracking(UID,FID,download_date) values($UID,$FID,now())");
		//print $this->db->get_query();
		$this->db->execute_query();
	}
	function format_size($size){
            $sizeinMB=$size/1048576;
            $sizeinKB=$size/1024;
            $sizeinB=$size;
            $formattedMB=sprintf("%.2f",$sizeinMB);
            $formattedKB=sprintf("%.2f",$sizeinKB);

			if($formattedMB<1){
                $displaysize=$formattedKB;
                $displaytype="KB";
                if($formattedKB<1){
                    $displaysize=$sizeinB;
                    $displaytype=" Bytes";
                }
            }else{
                $displaysize=$formattedMB;
                $displaytype="MB";
            }
			$display=$displaysize.$displaytype;
			return $display;
	}
	function list_files($ID){
		$this->db->set_query("select ID,file_name,file_size,UID from upload_tracking where UID=$ID");
		$this->db->execute_query();
	}
	function list_files_results(){
		return $this->db->get_results("both");
	}
	function get_mime_type($file){
		$result=`file -i "$file"`;
		$resultsplit=split(":",$result);
		$type=$resultsplit[1];
		$type=preg_replace("/[\r\n]+|[\s]+/","",$type);
		return $type;
	}
	function update_status($formdata){
		//will have fileID and the new status
		$status=$formdata["status"];
		$status=preg_replace("/>|<|\"/","",$status);
		$status=addslashes($status);
		$ID=$formdata["fileID"];
		$this->db->set_query("update upload_tracking set status='$status' where ID=$ID");
		$this->db->execute_query();
	}
	function get_download_history($FID){
		//Gets User: Date of file download
		$this->db=new DB("QuinnFM");
		$this->db->set_query("select a.login_name,date_format(b.download_date,'%M %D, %Y %l:%i%p')as ddate from users a, download_tracking b where a.ID=b.UID and b.FID=$FID");
		$this->db->execute_query();
		while($row=$this->db->get_results("assoc")){
			print $row["login_name"]." on ".$row["ddate"]."<br>";
		}
	}
}
?>
