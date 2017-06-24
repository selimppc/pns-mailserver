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
<style>
.unreadMsg {
	    color: #000;
	    font-weight: bold;
		font-size:16px;
		border-bottom:1px solid #eee;
	}
	.unreadMsg a{
	    color: #000;
	    font-weight: bold;
		font-size:16px;
		text-decoration:none;
		
	}
.unreadMsg a:hover{
	    color: #000;
	    font-weight: bold;
		text-decoration:none;
		
		
	}	
	.readMsg {
	    color: #800040;
	     font-weight: bold;
		border-bottom:1px solid #eee;
		
	}
	.readMsg a{
	    color: #800040;
	     font-weight: bold;
		text-decoration:none;
		
		
	}
	.readMsg a:hover{
	    color: #800040;
	     font-weight: bold;
		text-decoration:none;
		
		
	}
</style>
</head>

<body>
<?
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":993/imap/ssl/novalidate-cert}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
			
			//$check = imap_mailboxmsginfo($mbox);
			$result = imap_search($mbox, 'UNSEEN');
		
		$page= mysql_real_escape_string(htmlspecialchars(trim($_GET['p'])));
		$total= mysql_real_escape_string(htmlspecialchars(trim($_GET['total'])));
		if(($total-30)< 0)
			$amount = 0;
		else
			$amount = $total - 30;
?>

	<div style="height:938px;  width:800px; margin:0 auto; background:#eeeeee;">
           
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="message.php">Message Box</a> </div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div> 
          </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php">Create New</a></div></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center; margin-left:3px;"><div class="white"><a href="#">Unread (<? echo count($result) ?>)</a></div></div>
<div style="height:20px; width:175px;  color:#FFF; float:right;">
                	<div style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <div style="width:54px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="searchId.php">Search</a></div></div>
                    <div style="width:38px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="#">Trash</a></div></div>
                </div>
          </div>
          
        <div style="height:33px; width:770px; background:url(images/messagetopblue.png); color:#FFF; margin:0 auto;">
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">Subject</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:120px;">Received&nbsp;Date</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:55px;">From&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left;">Attachment&nbsp;</div>
        </div>
          
         <div style="width:788px; height:735px; overflow:auto;">
         	<?php
			$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":993/imap/ssl/novalidate-cert}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
			
			if(isset($_POST['submit']) && $_POST['submit'] == "unread")
			{
				$mid= mysql_real_escape_string(htmlspecialchars(trim($_POST['mid'])));	
				imap_clearflag_full($mbox, $mid, '\\Seen', ST_UID);
			}	
			
			//$check = imap_mailboxmsginfo($mbox);
						
			$a = $count % 30;
			$lastPage = $count / 30;
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
				
				$sub = preg_match_all('/[+_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/', $subject, $match);

				if ($sub) {
					$links=$match[0];
					for ($s=0;$s<$sub;$s++) {
						$subject=str_replace($links[$s],'<b style="color:red">(Email)</b>',$subject);
					}
				}
				
				$sub = preg_match_all('/[+_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/', $subject1, $match);

				if ($sub) {
					$links=$match[0];
					for ($s=0;$s<$sub;$s++) {
						$subject1=str_replace($links[$s],'<b style="color:red">(Email)</b>',$subject1);
					}
				}
				
				$uid = imap_uid($mbox, $i);
				
				$overview = imap_fetch_overview($mbox,$i);
				$class = $overview[0]->seen?'readMsg' : 'unreadMsg';
				
				
				$date = $headers->date;
				$date = date("d-M-Y H:i:s", strtotime($date));
				$structure = imap_fetchstructure($mbox , $i);
				$name = $structure->parts[1]->dparameters[0]->value; 
				//$type = $structure->parts[1]->type;
				
				$n = preg_match_all('/\'/', $from, $match3);
				if ($n) {
					
					for ($j=0;$j<$n;$j++) {
						$test4=str_replace($match3[$j],"\\'",$from );
					}
				}
				else
				$test4 = $from;
				
				 $sql = mysql_query("SELECT * FROM `registration` WHERE `userName` = '$test4'");
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
				
				$sqlid = mysql_query("SELECT * FROM `status` WHERE `uId` = '$i' ORDER BY `id` DESC ");
					$numid = mysql_num_rows($sqlid);
				
				if($numid == 0)
					{	
					echo "<tbody>";
					echo "<tr class=".$class." >";
					if($subject1 == $subject)		
						echo "<td width='270' style='padding-left:10px' height='38'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1</td>";
					else
						echo "<td width='270' style='padding-left:10px'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1...</td>";
						echo "<td width='260'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$date</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$id</a></td>";
					if(!empty($name))
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id&uid=$i'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					else
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id&uid=$i'></a></td>";
						
						echo "<form method='post' action='inbox.php?p=1&total=$count'>";?>
		                  	<input type="hidden" name="mid" id="mid" value=<? echo $uid ?> >
		                  	<?
		                  	echo"<td class='center'><input type='submit' name='submit' id='submit' value='unread' ></td>";
		                  	echo "</form>";	
		                  	//echo"<td class='center'>$uid</td>";										
					echo "</tr>";
					echo "</tbody>";
					
				}
				
				else
				{
					$status= mysql_fetch_array($sqlid);
					echo "<tbody>";
					echo "<tr class=".$class." >";
					
					if($subject1 == $subject)
					{
						if($status['status'] == 'reply' || $status['status'] == 'forward')
						{
						   if($status['status'] == 'reply' )		
							echo "<td width='270' style='padding-left:10px' height='38'><img src='images/reply.png' width='15' height='15' /> <a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1</td>";
						   else
						   	echo "<td width='270' style='padding-left:10px' height='38'><img src='images/forward.png' width='15' height='15' /> <a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1</td>";
						}
						else
						echo "<td width='270' style='padding-left:10px' height='38'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1</td>";
					}
					else
					{
						if($status['status'] == 'reply' || $status['status'] == 'forward')
						{
						    if($status['status'] == 'reply' )	
							echo "<td width='270' style='padding-left:10px'><img src='images/reply.png' width='15' height='15' /> <a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1...</td>";
						    else
						    echo "<td width='270' style='padding-left:10px'><img src='images/forward.png' width='15' height='15' /> <a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1...</td>";
						}
						else
							echo "<td width='270' style='padding-left:10px'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$subject1...</td>";
					}
						echo "<td width='260'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$date</a></td>";
						echo "<td width='80'><a href='messageshow.php?date=$date&id=$id&uid=$i'>$id</a></td>";
					if(!empty($name))
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id&uid=$i'><img src='images/attachment.png' height='30' width='30'/></a></td>";
					else
						echo "<td width='100' align='center'><a href='messageshow.php?date=$date&id=$id&uid=$i'></a></td>";
						
						echo "<form method='post' action='inbox.php?p=1&total=$count'>";?>
		                  	<input type="hidden" name="mid" id="mid" value=<? echo $uid ?> >
		                  	<?
		                  	echo"<td class='center'><input type='submit' name='submit' id='submit' value='unread' ></td>";
		                  	echo "</form>";	
		                  	//echo"<td class='center'>$uid</td>";										
					echo "</tr>";
					echo "</tbody>";
				
				}	
					
				}
				echo"</table>";
				?>
                </div>
                <div style="height:33px; width:778px; background:url(images/messagetopblue.png); color:#FFF; margin-top:20px; margin-bottom:20px;">
                <? $show = $page * 30;
		   $show1 = ($show - 30) +1; ?>
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