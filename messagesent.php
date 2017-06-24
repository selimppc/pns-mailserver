<?php
session_start();
include("check.php");
include("db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['userName'] .' \'s'.  " sent message"; ?></title>
<link rel="stylesheet" type="text/css" href="css/message.css" />
<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table_jui.css";
			@import "css/jquery-ui-1.8.4.custom.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
			$.extend( $.fn.dataTable.defaults, {
					"bSort": false
				} );
				Table = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );
		</script>

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
 
          <!---validation start from here.......................------------------------------->	
        <div id="dt_example">
          <div id="container">
		    <div class="demo_jui">
         
  <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="27%" >Subject</th>
			<th width="40%">Date Received</th>
            		<th width="21%">From</th>
            		<th width="12%">To</th>
		</tr>
	</thead>
	<tbody>
         	<?php
			$sql = mysql_query("SELECT * FROM `send_message` ORDER BY `date` DESC");
			$num = mysql_num_rows($sql);
			
			if($num == 0)
			{
				echo "<p><strong><span style='margin-left:60px;'>Your sent message box is emtpy</span></strong></p>";	
			}
			else
			{

				while($re= mysql_fetch_array($sql))
				{
					$id = $re['id'];	
					$sub = $re['sub'];	
					$from = $re['from'];
					$date = $re['date'];
					$to = $re['to'];
					
					//$staytime =  strtotime($time_out) - strtotime($time_out) / 60;
					
					
					echo"<tr class='gradeA'>";
						echo"<td class='center' height='40' width='27%'><a href='sendmessageshow.php?id=$id'>$sub</a></td>";
						echo"<td class='center' width='40%' ><a href='sendmessageshow.php?id=$id'>$date</a></td>";
			                 	echo"<td class='center' width='21%' ><a href='sendmessageshow.php?id=$id'>$from</a></td>";	
			                 	echo"<td class='center' width='12%'><a href='sendmessageshow.php?id=$id'>$to</a></td>";

					echo"</tr>";
				}
				?>
                </tbody>
			</table>

			</div>
		</div>
     </div>
     <? }?>
<!-----------------validation end here....----------------------------------------------->
			
      </div>
       <div style="height:33px; width:778px; background: url(images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>
</body>
</html>