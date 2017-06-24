<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forward Message</title>
<link rel="stylesheet" type="text/css" href="css/message.css" />
<link rel="stylesheet" type="text/css" href="css/yui.css" >

<style>
/*Supplemental CSS for the YUI distribution*/
#custom-doc { width: 95%; min-width: 950px; }

</style>

<link rel="stylesheet" type="text/css" href="css/dpSyntaxHighlighter.css">
<!--Script and CSS includes for YUI dependencies on this page-->
<link rel="stylesheet" type="text/css" href="css/simpleeditor.css" />
<link rel="stylesheet" type="text/css" href="css/button.css" />
<script language="Javascript" src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script language="Javascript" src="js/htmlbox.colors.js" type="text/javascript"></script>
	<script language="Javascript" src="js/htmlbox.styles.js" type="text/javascript"></script>
	<script language="Javascript" src="js/htmlbox.syntax.js" type="text/javascript"></script>
	<script language="Javascript" src="js/xhtml.js" type="text/javascript"></script>
	<script language="Javascript" src="js/htmlbox.min.js" type="text/javascript"></script>



</head>

<body>
<? 
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
?>
 <div style=" height:938px; width:800px; margin:0 auto; background:#eeeeee;"> 
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="#">Message Box</a></div> 
                <div class="topcontact" style="float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div>  
        </div>
		<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   				<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php">Create New</a></div></div>
<div style="height:20px; width:175px;  color:#FFF; float:right;">
                	<div id="menu" style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <div style="width:54px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="searchId.php">Search</a></div></div>
                    <div style="width:38px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="#">Trash</a></div></div>
                </div>
          </div>
        
        <?php 
		$id = mysql_real_escape_string(htmlspecialchars(trim($_GET['id'])));
		$date1 = mysql_real_escape_string(htmlspecialchars(trim($_GET['date'])));
		$uId=mysql_real_escape_string(htmlspecialchars(trim($_GET['uid'])));
				
		$sql = mysql_query("SELECT * FROM `registration` WHERE `id` = '$id'");
		$row = mysql_fetch_array($sql);
		$userName = $row['userName'];
		
		$headers = imap_headerinfo($mbox , $uId);
		$subject = $headers->subject;
		
		require_once 'EmailMessage.php';
		// obviously change these to your actual login details and server connection string
		
		$emailMessage = new EmailMessage($mbox, $uId);
		$emailMessage->fetch();
		
		
		// match inline images in html content
		
		if(preg_match_all('/src="cid:(.*)"/Uims', $emailMessage->bodyHTML, $matches))
		{
		// if there are any matches, loop through them and save to filesystem, change the src property
		// of the image to an actual URL it can be viewed at
		if(count($matches)) {
			
			// search and replace arrays will be used in str_replace function below
			$search = array();
			$replace = array();
			
			foreach($matches[1] as $match) {
				
				$uniqueFileName = '';
				$fullfilename = basename($match);
				if (strlen($fullfilename) > 0) {
					/* in case the file name is recovered, use that -> you might need to put in more checks to make sure no errors occur */
					$extension =  substr(strrchr($fullfilename,'.'),1);
					$justfilename = substr($fullfilename, 0, strlen($fullfilename) - strlen($extension) - 1);
					// and add a bit of randomness in the middle to avoid conflicts
					$uniqueFilename = $justfilename.'_'.date('dmYHis').'.'.$emailMessage->attachments[$match]['subtype'];
				}
				else {
					/* this is a basic unique naming system -> use todays date :) 
				    basic format: 'f_' followed by date and time, then after the '.' put in the subtype that the imap already fetched 
				    ... may not be the actual extension or the most commonly used one, but will suffice */
					$uniqueFilename = 'f_'.date('dmYHis').'.'.$emailMessage->attachments[$match]['subtype'];
				}
				// changed saving path according to you
				file_put_contents("save/$uniqueFilename", $emailMessage->attachments[$match]['data']);
				
				// just to see if its working
				//echo "Found file! Saved as $uniqueFilename!<br/>";
				
				$search[] = "src=\"cid:$match\"";
				
				// replace to link to your saved location
				$replace[] = "src=\"save/$uniqueFilename\"";
			}
			
			// now do the replacements
			$emailMessage->bodyHTML = str_replace($search, $replace, $emailMessage->bodyHTML);
			
			// just to see the mail
			//echo $emailMessage->bodyHTML;
			
		


		$m = preg_match_all('/[+_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/', $emailMessage->bodyHTML, $matchs);

		if ($m) {
			$links=$matchs[0];
			for ($j=0;$j<$m;$j++) {
				$emailMessage->bodyHTML=str_replace($links[$j],'<b style="color:red">(Email)</b>',$emailMessage->bodyHTML);
			}
		}
		
		//echo $body."<br/>" ;

		//imap_setflag_full($mbox, $uid, "\\Seen ", ST_UID);
		}
		
			
		$bodyFinal =  $emailMessage->bodyHTML ;
		}
		
		else
		{
			require_once('getParts.php');
			
			$body = getBody($uId, $mbox);
			
			$m = preg_match_all('/[+_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/', $body, $match);
	
			if ($m) {
				$links=$match[0];
				for ($j=0;$j<$m;$j++) {
					$body=str_replace($links[$j],'<b style="color:red">(Email)</b>',$body);
				}
			}
			
			
		$bodyFinal = $body ;
		
		}

				
				
		if(isset($_POST['action']) && $_POST['action'] == "Send")
		{
			$to = mysql_real_escape_string(htmlspecialchars(trim($_POST['to'])));	
			$cc = mysql_real_escape_string(htmlspecialchars(trim($_POST['cc'])));
			$bcc = mysql_real_escape_string(htmlspecialchars(trim($_POST['bcc'])));
			$sub = mysql_real_escape_string(htmlspecialchars(trim($_POST['sub'])));	
			$message = $_POST['si_article'];	
			$fileName = $_FILES["file"]["name"];
			
	
			$timezone = "Asia/Dacca";
			if(function_exists('date_default_timezone_set')) 
			date_default_timezone_set($timezone);
			$time = date('d-m-Y - h:i:s A');
			
			$err =  array();			
			
			if(isset($to) && isset($sub) && isset($message))
			{
				if(empty($to) && empty($sub) && empty($message))
					$err[] = "All field required";	
				else
				{
					// recepient checking...
					if(empty($to))
						$err[] = "Recepient address required";	
					
					$location = '';	
					if(!empty($fileName))
					{	
						$info = pathinfo($fileName);
						$file =  basename($fileName,'.'.$info['extension']);
						
						$thisdir ="ftp";
						$uniqer = substr(md5(uniqid(rand(),1)),0,5);
						$folder = $thisdir.'/'.$uniqer.$file;
						mkdir($folder , 0777,true);

						if ($_FILES["file"]["error"] > 0)
						{
							$err[] =  $_FILES["file"]["error"] ;	
						}
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  $folder.'/'  . $_FILES["file"]["name"]);
						  
						  $location = $folder.'/'  . $_FILES["file"]["name"] ;
					}	  
					//  seubject checking..
					
					if(empty($sub))
						$err[] = "Subject required";	
					elseif(strlen($sub) > 200)
						$err[] = "Your subject is too long"; 	
					
					
					// message checkiing...
					
					if(empty($message))
						$err[] = "Message required";	
					
					elseif(preg_match("/[^a-zA-Z0-9. , '' @ + % \-\ * ( )# ]$/ ", $to))
						  $err[] = "Wrong value contain in your To box";
						  
					elseif(!is_numeric($to))
					$err[] = "To is require numeric.";
					
					if(!empty($cc))
					{
						if(!is_numeric($cc))
						$err[] = "CC is require numeric.";
					}
					
					if(!empty($bcc))
					{
						if(!is_numeric($bcc))
						$err[] = "CC is require numeric.";
					}
				}
			}
			
			if(!empty($err))
			{
				foreach($err as $er)
				{
					echo"<div style='width:100%; background:#eeeeee;'>";
					echo "<font color=red style='padding-left:20px;'>$er<br/></font>";
					echo"</div>";
				}
			}
			else
			{
				$sql_msg = mysql_query("SELECT * FROM `registration` WHERE `id` = '$to'");
				$row = mysql_fetch_array($sql_msg);
				$receiver = $row['userName'];
				
				if(!empty($cc)){
				$sql_cc = mysql_query("SELECT * FROM `registration` WHERE `id` = '$cc'");
				$rowcc = mysql_fetch_array($sql_cc);
				$cc1= $rowcc['userName'];}
				
				if(!empty($bcc)){
				$sql_bcc = mysql_query("SELECT * FROM `registration` WHERE `id` = '$bcc'");
				$rowbcc = mysql_fetch_array($sql_bcc);
				$bcc1= $rowbcc['userName'];}
				
				if(!empty($cc) && !empty($bcc))
					$cc2 = $cc1.','.$bcc1;
				elseif(!empty($cc))
					$cc2 = $cc1;
				elseif(!empty($bcc))
					$cc2 = $bcc1;
					
				$userName = $_SESSION['userName'];
				$sqlinsert = mysql_query("INSERT INTO `send_message`(`id`, `to`,`cc`, `bcc`, `from`, `sub`, `message`, `attachment`,`location`,`date`) VALUES ('','$to','$cc', '$bcc','$userName','$sub','$message','$fileName','$location', now())");
				
				$sqlId = mysql_query("INSERT INTO `status`(`id`, `uId`, `status`) VALUES ('','$uId','forward')");		
				
				if($sqlinsert)
				{
					if($fileName ==''){		
					 $headers  = 'MIME-Version: 1.0' . "\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
					$headers .= 'From: info@clippingimages.com< info@clippingimages.com>' . "\r\n";  
					//$headers .= "Reply-To: ".$receiver."\r\n";  
					if(!empty($cc)) 
					$headers .= "CC:".$cc2." \r\n"; 
					elseif(!empty($bcc)) 
					$headers .= "CC:".$cc2." \r\n";
					  
					$emailTo = $receiver; //Put your own email address here
					// message
						
					//$message1.="<html><body>"; 
					//$message1.= '<p style="color:red;">This text should be red</p>';
					//$message1.= '<div>'.trim($_POST['si_article']).'</div>';  
				   	//$message1 = $message;
       					//$message1.="</body></html>"; 
       					
       					$message1 = '
					<html>
					<head>
					  <title>'.$sub.'</title>
					</head>
					<body>
					'.$message.'
					</body>
					</html>
					';
       					}
       					
					else
					{
					$emailTo = $receiver; //Put your own email address here
					
					$message1 = $message;
					$file1 = $folder.'/'.$fileName;
					$file_size = filesize($file1);
					$handle = fopen($file1, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
					$content = chunk_split(base64_encode($content));
					$uid = md5(uniqid(time()));
					$name = basename($file1);
					$headers = 'From: info@clippingimages.com < info@clippingimages.com >'."\r\n";
					//$headers .= "Reply-To: ".$receiver."\r\n";
					if(!empty($cc)) 
					$headers .= "CC:".$cc2." \r\n"; 
					elseif(!empty($bcc)) 
					$headers .= "CC:".$cc2." \r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
					$headers .= "This is a multi-part message in MIME format.\r\n";
					$headers .= "--".$uid."\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
					$headers .= $message1."\r\n\r\n";
					$headers .= "--".$uid."\r\n";
					$headers .= "Content-Type: application/octet-stream; name=\"".$fileName."\"\r\n"; // use different content types here
					$headers .= "Content-Transfer-Encoding: base64\r\n";
					$headers .= "Content-Disposition: attachment; filename=\"".$fileName."\"\r\n\r\n";
					$headers .= $content."\r\n\r\n";
					$headers .= "--".$uid."--";
					}
				
                		
					if(mail($emailTo, $sub, $message1, $headers))
					{
						echo"<div style='width:100%; background:#eeeeee;'>";
						echo "<font color=green><strong>Message Successfully Sent!</strong></font>";
						echo"</div>";
					}
					else
					{
						echo"<div style='width:100%; background:#eeeeee;'>";
						echo "<font color=red><strong>sent problem</strong></font>";
						echo"</div>";
					}
				}	
			}
		}
		
		
		?>
        <form action="<?php echo htmlentities($server); ?>" method="post" enctype="multipart/form-data" />
         <div style="height:33px; width:778px; background: #1f5e9e; color:#FFF;">
              <div style="margin-left:10px; padding-top:5px; float:left; margin-right:10px;"><div class="white">
              <input type="submit" value="Send" name="action" class="newcontactssave1"/>
              </div></div>
          	<div style="margin-left:10px; padding-top:9px; float:left;"><div class="white"><a href="message.php">Cancel</a></div></div>
        </div>
         <div style="height:180px; width:778px; background: #1f5e9e; color:#FFF;">
            <table style="margin-left:40px;" cellpadding="2" cellspacing="2">
                <tr>
                    <td width="20" align="right">To:&nbsp;</td>
                    <td width="603"><input type="text" name="to" size="70" value="<?php echo $id ?>" /></td>
                </tr>
                <tr>
                    <td width="20" align="right">CC:&nbsp;</td>
                    <td width="603"><input type="text" name="cc" size="70" value="<?php if(isset($_POST['cc'])) echo $_POST['cc']; ?>" /></td>
                </tr>
                <tr>
                    <td width="20" align="right">CC1:&nbsp;</td>
                    <td width="603"><input type="text" name="bcc" size="70" value="<?php if(isset($_POST['bcc'])) echo $_POST['bcc']; ?>" /></td>
                </tr>
                <tr>
                    <td align="right">Subject:&nbsp;</td>
                    <? if (preg_match("/Fw:/", $subject)){ ?>
                    <td><input type="text" name="sub" size="70" value="<?php echo $subject ?>" /></td>
                    <? }else{ ?>
                    <td><input type="text" name="sub" size="70" value="<?php echo"Fw: ".$subject ?>" /></td>
                    <? } ?>
                </tr>
                <tr>
                <td></td>
                <td><input type="file" name="file" id="file" /></td>
                </tr>
					
            </table>
           <div style=" height:600px; background-color:#565656; color:#FFF; text-align:center; padding-left:20px; padding-top:20px;">
           		<textarea name="si_article" id="si_article" rows="30" cols="90" >----- Forwarded Message -----<br><?php 
				echo $bodyFinal;  ?></textarea>
            </div>
            </form>
        </div>
        
  </div>
  <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
</div>
<script language="Javascript" type="text/javascript">
$("#si_article").css("height","400").css("width","600").htmlbox({
    toolbars:[
	    [
		// Cut, Copy, Paste
		"separator","cut","copy","paste",
		// Undo, Redo
		"separator","undo","redo",
		// Bold, Italic, Underline, Strikethrough, Sup, Sub
		"separator","bold","italic","underline","strike","sup","sub",
		// Left, Right, Center, Justify
		"separator","justify","left","center","right",
		// Ordered List, Unordered List, Indent, Outdent
		"separator","ol","ul","indent","outdent",
		// Hyperlink, Remove Hyperlink, Image
		"separator","link","unlink","image"
		
		],
		[// Show code
		"separator","code",
        // Formats, Font size, Font family, Font color, Font, Background
        "separator","formats","fontsize","fontfamily",
		"separator","fontcolor","highlight",
		],
		[
		//Strip tags
		"separator","removeformat","striptags","hr","paragraph",
		// Styles, Source code syntax buttons
		"separator","quote","styles","syntax"
		]
	],
	skin:"blue"
});
</script>
 
</body>
</html>