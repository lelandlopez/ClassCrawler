<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_root = "localhost";
$database_root = "ClassScraper";
$username_root = "lelandp";
$password_root = "Waiakea2009";
$asdf = mysql_pconnect($hostname_root, $username_root, $password_root) or trigger_error(mysql_error(),E_USER_ERROR); 
?>