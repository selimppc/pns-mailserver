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
		$sql1 = mysql_query("SELECT * FROM `registration` WHERE `password` != ''");
					$count1 = mysql_num_rows($sql1);
		
		
		$page= mysql_real_escape_string(htmlspecialchars(trim($_GET['p'])));
		$total= mysql_real_escape_string(htmlspecialchars(trim($_GET['total'])));
		
		if($page == 1)
			$amount = 0;
		else
			$amount = $total;
			
		$range = 50;
			
			$sql = mysql_query("SELECT * FROM `registration` WHERE `password` != '' LIMIT $amount, $range ");
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
          <div style="margin-left:10px; padding-top:5px; padding-left:15px; float:left; margin-right:80px;">ID</div>
          <div style="margin-left:10px; padding-top:5px; float:left; margin-right:230px;">User Name</div>
                <div style="margin-left:10px; padding-top:5px; float:left; margin-right:200px;">Full Name</div>
                <div style="margin-left:10px; padding-top:5px; float:left;">Edit</div>
                
        </div>
          
         <div style="width:788px; height:718px; overflow:auto">
         	<?php			
			$a = $count1 % 50;
			$lastPage = $count1 / 50;
			$lastPage = (int)$lastPage;
			
			$test =$lastPage * 50;
					$nextPage = $total +50;
					
			echo "<table border='0' cellpadding='5' cellspacing='5' width='770' id='color' style='border-collapse:collapse; margin:0 auto;' >";
				echo "<tr bgcolor='#f3f3f3'/>";					
								
				echo "</tr>";
				
				while($row = mysql_fetch_array($sql))
				{
					$id = $row['id'];
					$userName = $row['userName'];
					$fullName = $row['fullName'];
					
					
					echo "<tbody>";
					echo "<tr class='odd' >";
					
						echo "<td width='50' style='padding-left:20px;'><a href='#'>$id</td>";
						echo "<td width='150'><a href='#'>$userName</a></td>";
						echo "<td width='150'><a href='#'>$fullName</a></td>";	
						echo "<td width='40'><a href='edit-user.php?id=$id'>edit</a></td>";	
						
					echo "</tr>";
					echo "</tbody>";
				}
				echo"</table>";
				?>
                </div>
                <div style="height:33px; width:778px; background:url(../images/messagetopblue.png); color:#FFF; margin-top:20px; margin-bottom:20px;">
                
				<table width='210'  border='0' cellpadding='' cellspacing='' style="float:right;">
                  
                    <tr>
                    
						<?php if($page == 1){?> 		
                        	<td width='40'>&lt;&lt;</td>
                         <? }else{?>
                         	<td width='40' class="table"><a href="show-all.php?p=1&amp;total=0">&lt;&lt;</a></td>
                            
                         <?php }if($page == 1){?> 
                        	<td width='40' align="center">&lt;</td>
						<? }else{?> 
                        	<td width='40' align="center" class="table"><a href="show-all.php?p=<? echo $page-1 ?>&amp;total=<? echo $total-50 ?>">&lt;</a></td>
                            <? }?>
							<td width='55' align="center" bgcolor="#FFFFFF" style="color:#000"><? echo $page ?></td>
						<?php if($nextPage >= $count1){ ?>
							<td width='40' align="center" class="table">&gt;</td>
						<? }else{ ?>
                        	<td width='40' align="center" class="table"><a href="show-all.php?p=<? echo $page+1 ?>&amp;total=<? echo $total+50 ?>">&gt;</a></td>
						<?php }if(($nextPage) >= $count1){ ?>
                        	<td width='40' align="center">&gt;&gt;</td>
						<? }else{ ?>
							<td width='40' align="center" class="table"><a href="show-all.php?p=<? echo $lastPage+1 ?>&amp;total=<? echo $test ?>">&gt;&gt;</a></td>
                         <?  }?>	
                   	</tr>
                 </table>
        </div>
      </div>
      <div style="height:33px; width:778px; background: url(../images/ashcontact.png) no-repeat; margin:0 auto;" ><div class="topcontact" style="margin-left:500px; padding-top:5px;">Powered By <a href="http://www.creativeers.net/" target="_">Creativeers</a> </div></div>
    </div>

</body>
</html>