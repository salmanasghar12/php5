<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_seoExchangeDbConnection = "localhost";
$database_seoExchangeDbConnection = "seoexchange";
$username_seoExchangeDbConnection = "root";
$password_seoExchangeDbConnection = "raza";
$seoExchangeDbConnection = mysql_pconnect($hostname_seoExchangeDbConnection, $username_seoExchangeDbConnection, $password_seoExchangeDbConnection) or trigger_error(mysql_error(),E_USER_ERROR); 
?>