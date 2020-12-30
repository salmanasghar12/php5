<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION))
{
	session_start();
	}
	
		///////// function for getting SQL String value
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
 
	
		//checking if currently logged user is admin
if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){
	//check if $_GET[removeFeatured] is set.....
	if(isset($_GET['removeFeatured'])){
		//we will now remove the admin selected link from featured list....
		mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$queryRemoveFeatured = sprintf("UPDATE links SET isFeatured = 0 WHERE id = %s", GetSQLValueString($_GET['removeFeatured'], "int"));
		$RsRemoveFeatured = mysql_query($queryRemoveFeatured, $seoExchangeDbConnection) or die(mysql_errno());
		header("Location: ".$_SERVER['HTTP_REFERER']);
		}
	}
	
?>