<?php
if(!isset($_SESSION['userName']) || (trim($_SESSION['userName']) == '') )
{
header("location:index.php");
exit;
}
?>
