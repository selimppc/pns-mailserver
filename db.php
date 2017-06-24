<?php
$mysql_connect = mysql_connect("localhost", "clippin4_email", "email123") or die(mysql_error());
mysql_select_db("clippin4_mailserver") or die(mysql_error());

?>