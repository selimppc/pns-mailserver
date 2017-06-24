<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/message.css" />
<link rel="stylesheet" type="text/css" href="css/adminPanel.css" />
<title>Message Show</title>
</head>

<body>
<?
$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 // Total number of messages in Inbox
			$count = imap_num_msg($mbox );
			
			$date1= mysql_real_escape_string(htmlspecialchars(trim($_GET['date'])));
			$id=mysql_real_escape_string(htmlspecialchars(trim($_GET['id'])));
			$uid=mysql_real_escape_string(htmlspecialchars(trim($_GET['uid'])));
		
		//$sql = mysql_query("SELECT * FROM `registration` WHERE `userName` = '$from'");
		$sql = mysql_query("SELECT * FROM `registration` WHERE `id` = '$id'");
					$row = mysql_fetch_array($sql);
					$userName = $row['userName'];
					
		
		
?>         
 <div style=" height:938px; width:800px; margin:0 auto; background:#eeeeee;">      
     <div class="middleAccount">
       	<div class="ashcontacttop"> 
                        <div class="topcontact"><a href="message.php">Message Box</a> </div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="logout.php">Logout</a> </div> 
          </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="newmessage.php ">Create New</a></div></div>
   		<div style="height:20px; width:80px; float:left; margin-left:3px; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="reply.php?id=<? echo $id?>&date=<? echo $date1 ?>&uid=<? echo $uid?>">Reply</a></div></div>
   		<div style="height:20px; width:80px; float:left; margin-left:3px; background: #1f5e9e ; color:#fff; text-align:center;"><div class="white"><a href="reply.php?id=<? echo $id?>&date=<? echo $date1 ?>&uid=<? echo $uid?>">Forward</a></div></div>
<div style="height:20px; width:175px;  color:#FFF; float:right;">
                	<div id="menu" style="width:39px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Inbox</a></div></div>
                    <div style="width:33px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="messagesent.php">Sent</a></div></div>
                    <div style="width:54px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="searchId.php">Search</a></div></div>
                    <div style="width:38px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="#">Trash</a></div></div>
                </div>
          </div> 
        <?php
			
				//$uid = $uid-1;
				$headers = imap_headerinfo($mbox , $uid);
				$structure = imap_fetchstructure($mbox , $uid);
                    
                		$name = $structure->parts[1]->dparameters[0]->value; 
                		
                		$from = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
				$subject = $headers->subject;
				$date = $headers->date;
				$date = date("d-M-Y H:i:s", strtotime($date));
				
				if($date == $date1 && $userName ==$from )
				{
					

		
		?>
          
        <div style="height:33px; width:778px; background:#1f5e9e; color:#FFF;">
   		  <div style="margin-left:10px; padding-top:5px; float:left; margin-right:10px;"><b><?php echo $subject; ?></b> on <?php echo $date1; ?></div>
          <div style="margin-left:10px; padding-top:5px; float:right;">
          		<div style="float:left; width:50px;"><div class="white"><a href="inbox.php?p=1&total=<? echo $count ?>">Close</a></div></div>
          </div>
        </div>
        
        <div style="height:61px; width:778px; background: #1f5e9e; color:#FFF;">

        <table style="margin-left:40px;">
        	<tr>
        		<td width="44" align="right"><b>From:&nbsp;</b></td>
                <td width="370"><?php echo $id; ?></td>
                <td width="200"></td>
            </tr>
            <tr>
        		<td align="right"><b>To:&nbsp;</b></td>
                <td><?php echo "info@clippingimages.com"; ?></td>
                
            </tr>
        </table>
        </div>
        
        <div style="width:755px; height:680px;  color:#000; margin:30px; overflow:auto;">
         
        <div style="text-align:left; width:720px; border-bottom:1px #CCC solid; padding-bottom:10px;">
       
        <?php 

		
		require_once 'EmailMessage.php';
		// obviously change these to your actual login details and server connection string
		
		$emailMessage = new EmailMessage($mbox, $uid);
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
					
					$uniqer = substr(md5(uniqid(rand(),1)),0,5);
					// and add a bit of randomness in the middle to avoid conflicts
					$uniqueFilename = $uniqer.'_'.date('dmYHis').'.'.$emailMessage->attachments[$match]['subtype'];
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
		
			
		echo $emailMessage->bodyHTML."<br/>" ;
		}
		
		else
		{
			require_once('getParts.php');
			
			$body = getBody($uid, $mbox);
			
			$m = preg_match_all('/[+_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/', $body, $match);
	
			if ($m) {
				$links=$match[0];
				for ($j=0;$j<$m;$j++) {
					$body=str_replace($links[$j],'<b style="color:red">(Email)</b>',$body);
				}
			}
			
			
		echo $body."<br/>" ;
		
		}
		}
		?>
        
        </div>
        
        <div style="text-align:left; width:720px; padding-bottom:10px; padding-top:10px; min-height:20px;">
       			 Download&emsp;<? if(!empty($name)){ 
                for($j = 0; $j < count($structure->parts)-1; $j++)
				{ $name = $structure->parts[$j+1]->dparameters[0]->value;
					$k = $j +1; 
                ?><a href="attachmentClass.php?download=<? echo $k ?>&i=<? echo $uid ?>"><? echo $name ?> &nbsp;&emsp;</a><?echo $k ?>&emsp;<? }}?>
        
        </div>
        
        <? imap_close($mbox); ?>
        
        <div style="width:38px; height:20px; float:left; text-align:center; background-color:#1f5e9e; margin-top:10px;"><div class="white"><a href="reply.php?id=<? echo $id?>&date=<? echo $date1 ?>&uid=<? echo $uid ?>">Reply</a></div></div>
        </div>
        
      </div>

     <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
</div>
</body>
</html>