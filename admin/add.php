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
          <div style="margin-left:10px; padding-top:5px; padding-left:15px; float:left; margin-right:80px;">ID</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">Email Address</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:200px;">Full Name</div>
                <div style="margin-left:10px; padding-top:5px; float:left;">Edit</div>
                
        </div>
          
        <div style="width:788px; height:718px; overflow:auto">
        
        	<?		
			if(isset($_POST['submit']) && isset($_POST['submit']) == "Save")
			{
				$fullName= mysql_real_escape_string(trim($_POST['fullName']));
				$email= mysql_real_escape_string(trim($_POST['email']));
				$err = array();
				
				if(isset($fullName) && isset($email))
				{	
					if(empty($fullName) && empty($email))
						$err[] = "All Field required";	
					else
					{

						if(empty($fullName))	
							$err[] = "Name required";	
							
						$sqlCheck = mysql_query("SELECT userName FROM `registration` WHERE `userName` = '$email'");
						$check = mysql_num_rows($sqlCheck);
						
						if(empty($email))
							$err[] = "Email required";	
							
						else
						{if($check >0)
							$err[] = "This email address is Already in database.";
						}
					}
				
				if(!empty($err))
				{
					foreach($err as $er)
					{
						echo "<span style='font-family:Arial; font-weight:bold; margin:20px;'>";
						echo "<font color=##d80000>$er</font><br>";	
						echo "</span>";
					}	
				}
				
				else
				{
					$sqlSave = mysql_query("INSERT INTO `registration` VALUES ('','$email','$fullName','')");
					if($sqlSave)
					{
						echo "<span style='font-family:Arial; font-weight:bold; margin:20px;'>";
						echo "<font color=green>Succeessfully Saved.</font><br>";	
						echo "</span>";
						
						
					}
					else 
						echo "Some Problem.....";
				}
			}
		}
		?>
        <form method="post" action="add.php">
        <table width="499" height="125" border="0" align="center" style="margin-top:20px;">
        <tr>
        	<td style="font-size:18px; font-weight:bold;" align="right">Email Address:&emsp;</td>
            <td><input type="text" name="email" id="email"  value="" size="50" /></td>
        </tr>
        <tr>
        	<td style="font-size:18px; font-weight:bold;" align="right">Name:&emsp;</td>
            <td><input type="text" name="fullName" id="fullName" value="" size="50" /></td>
        </tr>
        <tr>
        	<td></td>
            <td><input type="submit" value="Save" name="submit" /></td>
        </tr>
            </table>
        </form>
        </div>
      </div>
      <div style="height:33px; width:778px; background: url(../images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>