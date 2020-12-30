<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION))
{
	session_start();
	}
	
	///////// funcation for getting SQL String value
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
	//checking $_GET[addFeatured] is set and any slot is empty for new link
		if(isset($_GET['addFeatured'])&&($_GET['fLinks']<'4')){
		//we will now add the admin selected link to featured list....
			mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
			$queryAddFeatured = sprintf("UPDATE links SET isFeatured = 1 WHERE id = %s", GetSQLValueString($_GET['addFeatured'], "int"));
		$RsAddFeatured = mysql_query($queryAddFeatured, $seoExchangeDbConnection) or die(mysql_errno());
		header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		else {//else no slot is empty, hence no Featured will be added..
		//Setting a session variable as
		$_SESSION['noEmptySlot']= 1;
		header("Location: ".$_SERVER['HTTP_REFERER']);	
		 }
	}
	
?>