<?php require_once('Connections/seoExchangeDbConnection.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>

<?php if (!isset($_SESSION)) {	//Checks if Usernot Logged and sets a session variable LoginFirst as True.
  session_start();
	if (!isset($_SESSION['MM_Username'])){
		$_SESSION['LoginFirst']=true;
		}
}
?>

<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?php	///////// funcation for getting SQL String value
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
?>


<?php 
//retriving all data from $_GET[] array...
$link1 = $_GET['link1'];// partner link id
$user1 = $_GET['user1'];// partner user id
$link2 = $_GET['link2'];// current user link id
$user2 = $_SESSION['MM_UserId'];// current user id, which is retrived from $_SESSION[] super global array....

$pEmail= $_GET['pEmail'];//this email will be used to notify the partner user about exchange...
$pUrl = $_GET['pUrl'];// partner's link Url
$pUrlTitle = $_GET['pUrlTitle'];// partner's link Title
$MyUrl = $_GET['MyUrl'];//current user link Url
$myUrlTitle = $_GET['myUrlTitle'];//current user link Title
$myEmail = $_GET['myEmail'];//Current user Email

if(empty($_GET['user1'])){$valid = 0;}else {$valid = 1;}// Checking if our partner's is registerd user on not..


//////we will insert a new record in exchangedLinks table and set values from above data
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetInsertNewExchanged = sprintf("INSERT INTO exchangedlinks (link1, user1, link2, user2, isValid) VALUES (%s, %s, %s, %s, %s)", GetSQLValueString($link1, "int"), GetSQLValueString($user1, "int"), GetSQLValueString($link2, "int"), GetSQLValueString($user2, "int"), GetSQLValueString($valid, "int"));
$RecordsetInsertNewExchanged = mysql_query($query_RecordsetInsertNewExchanged, $seoExchangeDbConnection) or die(mysql_error());


// now we will notify the partner user that current user has exchanged a link with his/her link....
//we will send mail message to partner user....
//
	$to = $pEmail;//to
	$from = "";//////////// here admin email address will be used while deploying...
			   //////////// currently postmaster email address will be used which is defined in php.ini
	$subject ="Message From SeoExchange";
	$message ="Dear User it is to inform you that a registered user on SeoExchange has choosen your link to exchange with his/her own link. To make this Exchange active please copy the given HTML Code/Script into your own link as this exchange will increase the traffic and page rank of your website/link.
	you can also visit to your partner's website to see your link is there or not.
	
Your Partner Email:  ".$myEmail."
Your Partner's Link:  ".$MyUrl."

HTML Code/Script : <a href=".$MyUrl.">".$myUrlTitle."</a>

";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	// sending mail
	$isSent = mail($to, $subject, $message);		

	



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeoExchange.com</title>
<script type="text/javascript" src="Scripts/HomePage.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>
</head>

<body>
<div id="HeaderText">
<p>Improve Ranking</p>
<p style="text-indent:25px">Increase Traffic</p>
<p style="text-indent:50px">Increase Revenue</p>
</div>

<div id="container" style="height:1279px">

<div id="header">
      <div id="logo"> <a href="index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div><!--logo ending div. -->
      <div id="navbar">
      <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="index.php">Home</a></li>
        <li><a href="AboutUs.php">About Us</a></li>
        <li><a href="LinkDirectory.php">Link Directory</a></li>
        <li><a href="SubmitLink.php">Submit Link</a></li>
        <li><a href="ExchangeLink.php">Exchange Link</a></li>
        <li><a href="ContactUs.php">Contact Us</a></li>
        <li><a href="Signup.php">Signup</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
</div>
      <div id="DivUserWelcome"><?php /////// displaying user info if user is logged
	   $urlLogout="<a href='/doLogout.php' style='color:#F6F6F6'> [Logout] </a>";
if (isset($_SESSION['MM_Username'])){echo "Welcome  ".$_SESSION['MM_Username']."  ".$urlLogout;
        /////// displaying admin panel if user is admin
         echo  "<br /><a href='/myAccount.php' style='color:#F6F6F6'> My Account </a><br />";}?>
          <?php if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
			  <a style='color:#F6F6F6' href="../admin.php">Admin Panel</a>
			  <?php }?>
      </div>
    <!--navbar ending div. -->
      <div id="searchbar">
        <form id="Searchform" name="Searchform" method="get" action="Search.php">
          <input name="searchField" type="text" id="searchField" placeholder=" Search Links....." />
          <input type="submit" name="searchButton" id="searchButton" value="  " />
          
        </form>
      </div><!--searchbar ending div. -->
  </div><!--header ending div. -->
  
  <div id="main">
<div id="sidebar">
      <div class="panel">
        <div class="panelHeading">Common Tasks</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
          <?php  /////// displaying user info if user is logged
		  if (isset($_SESSION['MM_Username'])){?>
		  <li><a href="../myAccount.php">My Account</a></li>
		  <?php }?>
            <a href="myLinks.php">
            <li>My Links</li>
            </a> 
            <a href="SubmitLink.php">
			<li>Add a Link</li>
            </a> 
            <a href="MyExchangedLinks.php"><li>My Exchanged Links</li></a>
            <a href="ExchangeLink.php"><li>Exchange a Link</li></a>
            <a href="RemoveMyLink.php">
                  <li>Remove My  Link</li>
            </a>
            <a href="AddFeatured.php">Add a Featured link</a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <div class="panel">
        <div class="panelHeading">Help</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <a href="/HowToSubmitLink.php">
              <li>How to Submit a link</li>
            </a> <a href="/HowToExchange.php">
        <li>How to Exchange link</li>
                </a> <a href="/HowToManage.php">
                  <li>Managing Exchanged links</li>
                  </a> <a href="/Tips.php">
                    <li>Tips and Tricks</li>
                    </a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <div class="panel">
        <div class="panelHeading">Rules and policies</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <a href="/LinkSubmitRules.php">
              <li>Link Submittion Rules</li>
            </a> <a href="/LinkExchangeRules.php">
        <li>Link Exchange Rules</li>
                </a> <a href="/Privacy.php">
                  <li>Privacy Policy</li>
                  </a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <!--<label for="searchbar"></label>-->
    </div>
  <!--sidebar ending div. -->
  <div id="content" style="height:980px">
    <div class="panel">
      <div class="panelBody">
        <div class="panel">
          <div class="panelBody">
          
<h1>Exchange a Link:</h1>
<a href=""></a>

<?php
if (isset($RecordsetInsertNewExchanged)&& isset($isSent)){
	echo "Link Exchange Successful.<br/><br/>";
	echo "Dear User An Email Message is sent to your Partner along with your email address and HTML Code/Scrit of your link. To make this exchange active please copy the given HTML Code/Script of Your Partner's link into your own link/Website.<br/><br/><br/>";
	echo "Your Partner Email: <a href=\"mailto:".$pEmail."\">".$pEmail."</a>";
	echo "<br/><h4>HTML Code/Script :</h4>";
	echo "<textarea name=\"htmlScript\" cols=\"60\" rows=\"10\"><a href=\"".$pUrl."\">".$pUrlTitle."</a></textarea>";
}
	else{echo "Exchange Failed...";}
?>

          </div>
          <!--panelBody ending div-->
          </div>
        </div>
      </div>
    <!--panel ending div-->
  </div>

  <!--content ending div. -->
  </div><!--main ending div. -->
  
<div id="footer">
      <div id="footnav">
        <ul>
          <a href="index.php"><li>Home Page</li></a>
          <a href="LinkDirectory.php"><li>link directory</li></a>
          <a href="SubmitLink.php"><li>submit link</li></a>
          <a href="ExchangeLink.php"><li>exchange link</li></a>
          <a href="Signup.php"><li>signup</li></a>
          <a href="login.php"><li>Login</li></a>
          <?php ////// displaying admin panel if user is admin
		  if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
			  <a href="../admin.php"><li>Admin</li></a>
			  <?php }?>
        </ul>
      </div>
      <!--footnav ending div. -->
      <div id="footcontent">
      
      <ul>
          <a href="AboutUs.php"><li>About Us</li></a>
        <a href="ContactUs.php"><li>Contact Us</li></a>
        <a href="TermConditions.php"><li>Terms & Condition</li></a>
   	    <a href="Privacy.php"><li>Privacy Policy</li></a>
        <a href="index.php"><li>Sitemap</li></a>
        </ul>
      
      </div><!--footcontent ending div. -->
      <div id="copyright">
      
    				<!--	dynamically changing year-->       
Copyright &copy; <?php echo date('Y');?> All Rights Reserved

      </div><!--copright ending div. -->
  </div>
<p><!--footer ending div. --></p>
</div>
<!--container ending div. -->
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>

