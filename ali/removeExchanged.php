<?php require_once('Connections/seoExchangeDbConnection.php'); 
//initialize the session
if (!isset($_SESSION))
{
	session_start();
	}
	?>
<?php ///////// function for getting SQL String value
if (!function_exists("GetSQLValueString")){
	
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
if (isset($_GET['id'])){
	if($_GET['status']==1){//if user1 is current user and sets user1 to NULL
		mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_RemoveExchangedLink = sprintf("UPDATE exchangedlinks SET user1 = NULL, isValid = '0' WHERE id = %s AND user1 = %s", GetSQLValueString($_GET['id'], "int"), GetSQLValueString($_SESSION['MM_UserId'], "int")); 
$RecordsetRemoveExchangedLink = mysql_query($query_RemoveExchangedLink, $seoExchangeDbConnection) or die(mysql_error());

			// IF user1 is not current user then user2 will be, and sets user2 to NULL and isValid to false
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_RemoveExchangedLink2 = sprintf("UPDATE exchangedlinks SET user2 = NULL, isValid = '0' WHERE id = %s AND user2 = %s", GetSQLValueString($_GET['id'], "int"), GetSQLValueString($_SESSION['MM_UserId'], "int")); 
$RecordsetRemoveExchangedLink2 = mysql_query($query_RemoveExchangedLink2, $seoExchangeDbConnection) or die(mysql_error());


//Retriving Current user Email Address
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_CurrentUserEmail = sprintf("SELECT email FROM users WHERE id =%s", GetSQLValueString($_SESSION['MM_UserId'], "int")); 
$RecordsetCurrentUserEmail = mysql_query($query_CurrentUserEmail, $seoExchangeDbConnection) 
or die(mysql_error());
$Row_RecordsetCurrentUserEmail = mysql_fetch_assoc($RecordsetCurrentUserEmail);
$CurrentUserEmail = $Row_RecordsetCurrentUserEmail['email'];//will be  used as partner user's email while sending email.





//we will also notify the partner user that current user has removed the exchangedlink from its side....
//we will send mail message to partner user....
//
	$to = $_GET['partneremail'];//to
	$from = "";//////////// here admin email address will be used while deploying...
			/////////// currently postmaster email address will be used which is defined in php.ini
	$subject ="Message From SeoExchange";
	$message ="Dear User it is to inform you that one of your Partner by which you have exchanged your link has removed your link from its side so it is advised to please visit your partner website and check that your link is there or not. So that you can take your desired action.
	
Your Partner Email:  ".$CurrentUserEmail."
Your Partner's Link:  ".$_GET['mylink']."
";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	// sending mail
	mail($to, $subject, $message);		
	
	}
	
	
	
	
		else{ //in this if status is 0 then we will remove the entire record...
		mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
		$query_RemoveExchangedLink = sprintf("DELETE FROM exchangedlinks WHERE id = %s", GetSQLValueString($_GET['id'], "int")); 
	$RecordsetRemoveExchangedLink = mysql_query($query_RemoveExchangedLink, $seoExchangeDbConnection) 
	or die(mysql_error());
			}
		
	}
//redirecting user to previous page....
header("location: MyExchangedLinks.php");

?>
