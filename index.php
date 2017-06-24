<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
<head>
 <title>login form</title>
 
 <meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
 
 <link rel="stylesheet" type="text/css" href="css/style.css" />

  <!--[if lt IE 8.]>
<link rel="stylesheet" type="text/css" href="css/style-ie.css" />
<![endif]-->
 <!--[if lt IE 7.]>
<link rel="stylesheet" type="text/css" href="css/style-ie6.css" />
<![endif]-->
</head>

<body>
<div style=" width:650px; height:110px; margin:0 auto; margin-top:150px; text-align:left;"> <img src="images/header-logo.png" width="230" height="230" /></div>
<!-- Main Body Starts Here -->
<div style="width:526px;margin-top:10px;text-align:left;height:295px;background:url(images/form_BG.png) no-repeat left;padding:20px 0px 0px 43px">

<!-- Form Title Starts Here -->
<div class="form_title">
<img src="images/form_title.gif" alt="" />
</div>
<!-- Form Title Ends Here -->

<!-- Form Starts Here -->
<div class="form_box">
<?php 
      
      if(isset($_POST['login']) == "Log In")
      {
		include("db.php");
		ob_start();
		session_start();

        $username           = $_POST['username'];
        $password           = $_POST['password'];
		
        
            $result          = mysql_query("SELECT * FROM `registration` WHERE `userName` = '$username' AND `password` = '$password'");
            $check = mysql_num_rows($result);
			
            if($check == 1 )
            {
				$row = mysql_fetch_array($result);
				$_SESSION['userName']=$row['userName'];
               					print "<script>";
			  		 		print " self.location='message.php';"; // Comment this line if you don't want to redirect
				  		print "</script>";	
            }
            else
            {?>
                <span style="color:red; font-size:14px;"><?php echo "Wrong user name or password.<br><br>";?></span>
      <?php }
        
      }
?>
<form id="loginform" name="loginform" method="post" action="index.php">

<!-- User Name -->
<p class="form_text">
*User Name
</p>

<p class="form_input_BG"><input type="text" name="username" id="username" value=""/></p>
<!-- User Name -->

<!-- Clear -->
<p class="clear">&nbsp;
</p>
<!-- Clear -->

<!-- Password -->
<p class="form_text" style="margin-left:8px;">
*Password
</p>

<p class="form_input_BG"><input type="password" name="password" id="password" value=""/></p>
<!-- Password -->

<!-- Clear -->
<p class="clear">&nbsp;
</p>
<!-- Clear -->

<input style="margin-left:96px;" type="submit"  name="login" id="login" value="Log In"/>
</form>

</div>
<!-- Form Ends Here -->

</div>
<!-- Main Body Ends Here -->


 </body>
</html>