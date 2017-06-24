<?php
session_start();
include("check.php");
include("db.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link rel="stylesheet" type="text/css" href="css/message.css" />

</head>

<body>
<? 
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":993/imap/ssl/novalidate-cert}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");;
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox);
			

?>

	<div style=" height:938px; width:800px; margin:0 auto; background:#eeeeee;">
           
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="message.php">Message Box</a> </div> <div class="topcontact" style="float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div> 
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
        <div style="height:33px; width:778px; background: url(images/messagetopblue.png); color:#FFF;"></div>
          
         <div style="margin:20px; text-align:center;">

            <h1 style="color:#099;">Welcome to PNS mailserver</h1>
            <?
			//$check = imap_mailboxmsginfo($mbox);
			echo "<h2>You have</h2><br> ";
			echo "<h3>Messages: <strong style='color:green'>" . $count    . "</strong></h3>" ;
			 //echo "<h3>Messages: <strong style='color:green'>" . $check->Nmsgs   . "</strong></h3>" ;
			//echo "<h3>Recent: <strong style='color:green'>"   . $check->Recent  . "</strong></h3>" ;
			//echo "<h3>Unread: <strong style='color:green'>"   . $check->Unread  . "</strong></h3>" ;
			$result = imap_search($mbox, 'UNSEEN');
			echo "<h3>Unread: <strong style='color:green'>"   . count($result)  . "</strong></h3>" ;
			//echo count($result);	
			imap_close($mbox);
			?>

        </div>
      </div>
       <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>