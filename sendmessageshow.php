<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['userName'] .' \'s'.  " message show"; ?></title>
<link rel="stylesheet" type="text/css" href="css/message.css" />
<link rel="stylesheet" type="text/css" href="css/adminPanel.css" />

</head>

<body>
<? 
$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
			$id = (int) mysql_real_escape_string(htmlspecialchars(trim($_GET['id'])));
?>

  <div style=" height:938px; width:800px; margin:0 auto; background:#eeeeee;">                 
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="#">Message Box</a></div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div>
        </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   				<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php">Create New</a></div></div>
   				<div style="height:20px; width:80px; float:left; margin-left:3px; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="send-forward.php?id=<? echo $id?>">Forward</a></div></div>
<div style="height:20px; width:175px;  color:#FFF; float:right;">
                	<div id="menu" style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <div style="width:54px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="searchId.php">Search</a></div></div>
                    <div style="width:38px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="#">Trash</a></div></div>
                </div>
          </div>
        
        <?php
		$id = (int) mysql_real_escape_string(htmlspecialchars(trim($_GET['id'])));
		$sql = mysql_query("SELECT * FROM send_message WHERE id = '$id'");		
		$re = mysql_fetch_array($sql);
		
			$sub = mysql_real_escape_string(htmlspecialchars(trim($re['sub'])));
			$from = mysql_real_escape_string(htmlspecialchars(trim($re['from'])));
			$to = mysql_real_escape_string(htmlspecialchars(trim($re['to'])));
			$cc = mysql_real_escape_string(htmlspecialchars(trim($re['cc'])));
			$bcc = mysql_real_escape_string(htmlspecialchars(trim($re['bcc'])));
			$message = mysql_real_escape_string(trim($re['message']));
			$date = mysql_real_escape_string(htmlspecialchars(trim($re['date'])));
			$location = mysql_real_escape_string(htmlspecialchars(trim($re['location'])));
			$attachment = mysql_real_escape_string(htmlspecialchars(trim($re['attachment'])));
		?>
          
        <div style="height:33px; width:778px; background: #1f5e9e; color:#FFF;">
   		  <div style="margin-left:10px; padding-top:5px; float:left; margin-right:10px;"><b><?php echo $sub; ?></b> on <?php echo $date; ?></div>
          <div style="margin-left:10px; padding-top:5px; float:right;">
          		<div style="float:left; width:50px;"><div class="white"><a href="messagesent.php">Close</a></div></div>
          		
          </div>
        </div>
        
        <div style="height:61px; width:778px; background: #1f5e9e; color:#FFF;">
        <table style="margin-left:40px;">
        	<tr>
        		<td width="44" align="right"><b>From:&nbsp;</b></td>
                <td width="486"><?php echo $from; ?></td>
            </tr>
            <tr>
        		<td align="right"><b>To:&nbsp;</b></td>
                <td><?php echo $to; ?>&emsp;&emsp;
                	<?php
                	if(!empty($cc) && !empty($bcc))
					$cc2 = $cc.' , '.$bcc;
				elseif(!empty($cc))
					$cc2 = $cc;
				elseif(!empty($bcc))
					$cc2 = $bcc;
					
				if(!empty($cc) || !empty($bcc))
					echo "CC:&nbsp;".$cc2;
                	
                	?>
                
                </td>
                
            </tr>
        </table>
        </div>
        
        <div style="width:760px; height:700px; color:#000; margin:30px; overflow:auto;">
        
        <div style="text-align:left; width:720px; border-bottom:1px #CCC solid; padding-bottom:10px;">
        
        <?php 
		$message = ucfirst($message);
		echo str_replace('\r\n', '&nbsp;', $message);		
		?>

        </div>
        <?
        if(!empty($location))
        {?>
        Attachment: <a href="download.php?download_file=<? echo $attachment ?>"><? echo $attachment ?></a><? }?>
      </div>
      </div>
      
            <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
</div>
</body>
</html>