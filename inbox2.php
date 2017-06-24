<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>message inbox</title>
<link rel="stylesheet" type="text/css" href="css/message.css" />

</head>

<body>
<?
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
		
		$page= mysql_real_escape_string(htmlspecialchars(trim($_GET['p'])));
		$total= mysql_real_escape_string(htmlspecialchars(trim($_GET['total'])));
		if(($total-50)< 0)
			$amount = 0;
		else
			$amount = $total - 50;
?>

	<div style="height:938px;  width:800px; margin:0 auto; background:#eeeeee;">
           
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="message.php">Message Box</a> </div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div> 
          </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php">Create New</a></div></div>
<div style="height:20px; width:175px;  color:#FFF; float:right;">
                	<div style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <div style="width:54px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="searchId.php">Search</a></div></div>
                    <div style="width:38px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="#">Trash</a></div></div>
                </div>
          </div>
          
        <div style="height:33px; width:770px; background:url(images/messagetopblue.png); color:#FFF; margin:0 auto;">
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">Subject</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:155px;">Data Received&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:55px;">From&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left;">Attachment&nbsp;</div>
        </div>
          
         <div style="width:788px; height:735px; overflow:auto;">
         	<?php
			$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', 'CI@Mailsrv') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
						
			$a = $count % 50;
			$lastPage = $count / 50;
			$lastPage = (int)$lastPage;
			echo "<table border='0' cellpadding='5' cellspacing='5' width='770' id='color' style='border-collapse:collapse; margin:0 auto;' >";
				echo "<tr bgcolor='#f3f3f3'/>";					
								
				echo "</tr>";
				// Read Messages in Loop, Forward it to Actual User email and than delete it from current email account.
				for ($i = $total; $i > $amount; $i--) {
				$headers = imap_headerinfo($mbox , $i);
				
				$from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
				$subject = $headers->subject;
				$subject1 = substr($subject, 0, 40);
				
				$date = $headers->date;
				$date = date("d-M-Y H:i:s", strtotime($date));
				$structure = imap_fetchstructure($mbox , $i);
				$name = $structure->parts[1]->dparameters[0]->value; 
				//$type = $structure->parts[1]->type;
				
				 $sql = mysql_query("SELECT * FROM `registration` WHERE `userName` = '$from'");
					$check = mysql_num_rows($sql);
					
					if($check > 0 )
					{
						$row = mysql_fetch_array($sql);
						$id = $row['id'];
					}
					
					else
					{
						$sql1 = mysql_query("INSERT INTO `registration`(`id`, `userName`, `fullName`, `password`) VALUES ('','$from','','')");
						$sql2 = mysql_query("SELECT * FROM `registration` WHERE `userName` = '$from'");
						$row1 = mysql_fetch_array($sql2);
						$id = $row1['id'];
					 }
				//$type = $this->get_mime_type($structure);
				
				// GET HTML BODY
				// $body = $this->get_part($connection, $i, "");
				
				//echo $raw_body = imap_body($connection, $i);
				
				//$text = imap_qprint( imap_fetchbody($mbox , $i, 1));     
				
					
					//$staytime =  strtotime($time_out) - strtotime($time_out) / 60;
					if($i%2==0){
					echo "<tbody>";
					echo "<tr class='odd' >";
					if($subject1 == $subject)		
						echo "<td width='270' style='padding-left:10px' height='38'><a href='messageshow.php?date=$date&id=$id'>$subject1</td>";
					else
						echo "<td width='270' style='padding-left:10px'><a href='messageshow.php?date=$date&id=$id'>$subject1...</td>";
						echo "<td width='260'><a href='messageshow.php?date=$date&id=$id'>$date</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$id'>$from </a></td>";
					if(!empty($name))
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					else
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id'></a></td>";											
					echo "</tr>";
					echo "</tbody>";}
					
					else{
					echo "<tbody>";
					echo "<tr class='even' >";
					if($subject1 == $subject)		
						echo "<td width='270' style='padding-left:10px' height='38'><a href='messageshow.php?date=$date&id=$id'>$subject1</td>";
					else
						echo "<td width='270' style='padding-left:10px'><a href='messageshow.php?date=$date&id=$id'>$subject1...</td>";
						echo "<td width='260'><a href='messageshow.php?date=$date&id=$id'>$date</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$id'>$from </a></td>";
					if(!empty($name))
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					else
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id'></a></td>";											
					echo "</tr>";
					echo "</tbody>";}
					
				}
				echo"</table>";
				?>
                </div>
                <div style="height:33px; width:778px; background:url(images/messagetopblue.png); color:#FFF; margin-top:20px; margin-bottom:20px;">
                <? $show = $page * 50;
		   $show1 = ($show - 50) +1; ?>
                <div style="float:left; color:#FFF; padding-top:5px; margin-left:10px;">Showing <? echo $show1 ?> to <? echo $show ?> of <? echo $count ?> messages <? echo $cnt; ?></div>
				<table width='210'  border='0' cellpadding='' cellspacing='' style="float:right;">
                  
                    <tr>
                    
						<?php if($page == 1){?> 		
                        	<td width='40'>&lt;&lt;</td>
                         <? }else{?>
                         	<td width='40' class="table"><a href="inbox.php?p=1&total=<? echo $count ?>">&lt;&lt;</a></td>
                            
                         <?php }if($page == 1){?> 
                        	<td width='40' align="center">&lt;</td>
						<? }else{?> 
                        	<td width='40' align="center" class="table"><a href="inbox.php?p=<? echo $page-1 ?>&total=<? echo $total+15 ?>">&lt;</a></td>
                            <? }?>
							<td width='55' align="center" bgcolor="#FFFFFF" style="color:#000"><? echo $page ?></td>
						<?php if($i == 0){ ?>
							<td width='40' align="center" class="table">&gt;</td>
						<? }else{ ?>
                        	<td width='40' align="center" class="table"><a href="inbox.php?p=<? echo $page+1 ?>&total=<? echo $i ?>">&gt;</a></td>
						<?php }if($i == 0){ ?>
                        	<td width='40' align="center">&gt;&gt;</td>
						<? }else{ ?>
							<td width='40' align="center" class="table"><a href="inbox.php?p=<? echo $lastPage+1 ?>&total=<? echo $a ?>">&gt;&gt;</a></td>
                         <?  }?>	
                   	</tr>
                 </table>
        </div>
      </div>
      <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>