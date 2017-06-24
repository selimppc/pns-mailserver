<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>message search</title>
<link rel="stylesheet" type="text/css" href="css/message.css" />

</head>

<body>
<?
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
?>

	<div style="height:938px;  width:800px; margin:0 auto; background:#eeeeee;">
           
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="message.php">Message Box</a> </div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div> 
        </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php">Create New</a></div></div>
<div style="height:20px; width:250px;  color:#FFF; float:right;">
                	<div style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <form action="searchId.php"  method="post">
                    <div style="width:80px; height:100%; float:left; margin-right:10px; text-align:center;"><div class="white"><a href="#"><input type="search" name="search" placeholder="Enter ID" size="10" style="margin-right:10px;" /></a></div></div>
                    <span class="white">
                    <input type="submit" name="submit" value="Search" style="width:70px; height:100%; float:left; text-align:center; background:#1f5e9e; color:#FFF; float:right;" />
                    </span>
                    </form>
                </div>
        </div>
          <? 
          	if(isset($_POST['submit']) && isset($_POST['submit']) == "Search")
				{
					$search = mysql_real_escape_string(trim($_POST['search']));
					
					$sql = mysql_query("SELECT * FROM `registration` WHERE `id` = '$search'");
					$check = mysql_num_rows($sql);
					
					if($check == 0 )
					{	
						echo"<div style='width:100%; margin-top:30px;font-size:18px'>";
						echo "<font color=red style='padding-left:20px;'>This id is not in the database.<br/></font>";
						echo"</div>";
						
					}
				else
				{	
					$row = mysql_fetch_array($sql);
					$serachId = $row['userName'];
          ?>
        <div style="height:33px; width:770px; background:url(images/messagetopblue.png); color:#FFF; margin:0 auto;">
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">Subject</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:80px;">Data Received&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:85px;">From&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:40px;">To&nbsp;</div>
                
        </div>
          
        <div style="width:788px; height:770px; overflow:auto;">
         	<?php
						
			echo "<table border='0' cellpadding='5' cellspacing='5' width='770' id='color' style='border-collapse:collapse; margin:0 auto;' >";
				echo "<tr bgcolor='#f3f3f3'/>";					
								
				echo "</tr>";
				// Read Messages in Loop, Forward it to Actual User email and than delete it from current email account.
				
				for ($i = $count; $i >= 1; $i--) {
				$headers = imap_headerinfo($mbox , $i);
				
				$from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
				$subject = $headers->subject;
				$subject1 = substr($subject, 0, 50);
				
				$date = $headers->date;
				$date = date("d-M-Y H:i:s", strtotime($date));
				//$structure = imap_fetchstructure($mbox , $i);
				
				//$name = $structure->parts[1]->dparameters[0]->value; 
				$uid = imap_uid($mbox, $i);
				//$uid = $uid +1;
				if($serachId == $from)
				{
					
					echo "<tbody>";
					echo "<tr class='odd' >";
					if($subject1 == $subject)		
						echo "<td width='270' style='padding-left:10px' height='38'><a href='messageshow.php?date=$date&id=$search&uid=$uid'>$subject1</td>";
					else
						echo "<td width='270' style='padding-left:10px'><a href='messageshow.php?date=$date&id=$search&uid=$uid'>$subject1...</td>";
						echo "<td width='240'><a href='messageshow.php?date=$date&id=$search&uid=$uid'>$date</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$search&uid=$uid'>$search</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$search&uid=$uid'></a></td>";
					//if(!empty($name))
						//echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$search&uid=$uid'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					//else
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$search&uid=$uid'></a></td>";											
					echo "</tr>";
					echo "</tbody>";

					
				}
				
				}

				$sql1 = mysql_query("SELECT * FROM `send_message` WHERE `to` = '$search'");
				$check1 = mysql_num_rows($sql);
					
					if($check1 == 0 )
					{
						echo "This id is not in the database.";
					}
				else
				{	while($row1 = mysql_fetch_array($sql1))
					{
						$id = $row1['id'];
						$sub = $row1['sub'];
						$message = $row1['message'];
						$attachment = $row1['attachment'];
						$date1 = $row1['date'];
						
					echo "<tbody>";
					echo "<tr class='odd' >";
					
						echo "<td width='270' style='padding-left:10px'><a href='sendmessageshow.php?id=$id'>$sub</td>";
						echo "<td width='260'><a href='sendmessageshow.php?id=$id'>$date1</a></td>";
						echo "<td width='140'><a href='sendmessageshow.php?id=$id'></a></td>";
						echo "<td width='50'><a href='sendmessageshow.php?id=$id'>$search</a></td>";
					if(!empty($attachment))
						echo "<td width='100' align='center'><a href='sendmessageshow.php?id=$id'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					else
						echo "<td width='100' align='center'><a href='sendmessageshow.php?id=$id'></a></td>";											
					echo "</tr>";
					echo "</tbody>";
					
					}
				}
				}
				echo"</table>";
				}
				?>
                </div>
      </div>
      <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto; margin-top:30px;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>