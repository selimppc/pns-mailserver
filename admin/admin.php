<?php
session_start();
include("../check.php");
include("../db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>message inbox</title>
<link rel="stylesheet" type="text/css" href="../css/message.css" />

</head>

<body>
<?
		$sql = mysql_query("SELECT * FROM `registration` WHERE `password` = ''");
					$count = mysql_num_rows($sql);
		
		
?>

	<div style="height:938px;  width:800px; margin:0 auto; background:#eeeeee;">
           
      <div class="middleAccount">
       	<div class="ashcontacttop">
                <div class="topcontact"><a href="#">Message Box</a> </div> <div class="topcontact" style=" float:right; text-align:right; padding-right:10px;"><a href="../logout.php">Logout</a> </div> 
          </div>
<div style="height:49px; width:100%; background-color:#eeeeee;">
          		<div style="height:15px;width:100%;"></div>
   		<div style="height:20px; width:80px; float:left; background: #1f5e9e ; color:#fff; text-align:center;">
   		  <div class="white"><a href="admin.php">Admin</a></div></div>
<div style="height:20px; width:80px; float:left;  margin-left:3px; background: #1f5e9e ; color:#fff; text-align:center;">
   		  <div class="white"><a href="search.php">Search</a></div></div>
<div style="height:20px; width:275px;  color:#FFF; float:right;">
                	<div style="width:70px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white" ><a href="show-all.php?p=1&amp;total=0">Show Email</a></div></div>
                    <div style="width:60px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="add.php">Add Email</a></div></div>
                    <div style="width:60px; height:100%; float:left; margin-right:3px; text-align:center; background-color:#1f5e9e;"><div class="white"><a href="add-user.php">Add User</a></div></div>
                    <div style="width:70px; height:100%; float:left; text-align:center; background:#1f5e9e;"><div class="white"><a href="show-user.php?p=1&amp;total=0">Show User</a></div></div>
      </div>
          </div>
          
        <div style="height:33px; width:770px; background:url(../images/messagetopblue.png); color:#FFF; margin:0 auto;">
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">Subject</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:140px;">Data Received&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:60px;">From&nbsp;</div>
                <div style="margin-left:10px; padding-top:5px; float:left;">Attachment&nbsp;</div>
        </div>
          
         <div style="width:778px; height:720px; padding:50px;">
         	<?
		 		if(isset($_POST['cashclear'])== 'Cash Clear') 
				{
					$files = glob('../save/*'); // get all file names
						foreach($files as $file){ // iterate files
						  if(is_file($file))
							unlink($file); // delete file
						}	
				} 
					
						
		 ?>
         	<form method="post" action="admin.php" style=" margin-left:200px; font-size:16px;" >
                <input type="submit"  value="Cash Clear" name="cashclear" style="font-size:20px;"  />
                </form>
         </div>
      </div>
      <div style="height:33px; width:778px; background: url(../images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>