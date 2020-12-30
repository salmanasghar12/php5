<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
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
<?php ///////// funcation for getting SQL String value
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
/////////////getting categories from category table //////////////////////////
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetCategories = "SELECT DISTINCT category.name FROM category ORDER BY category.name";
$RecordsetCategories = mysql_query($query_RecordsetCategories, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories);
$totalRows_RecordsetCategories = mysql_num_rows($RecordsetCategories);
?>
<?php
//initialize the session
if (!isset($_SESSION))
{
	session_start();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeoExchange.com</title>
<script type="text/javascript" src="Scripts/HomePage.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
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
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="HeaderText">
<p>Improve Ranking</p>
<p style="text-indent:25px">Increase Traffic</p>
<p style="text-indent:50px">Increase Revenue</p>
</div>

<div id="container">

<div id="header">
      <div id="logo"> <a href="index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div><!--logo ending div. -->
      <div id="navbar">
      <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="index.php">Home</a></li>
        <li><a href="AboutUs.php">About Us</a></li>
        <li><a href="LinkDirectory.php">Link Directory</a></li>
        <li><a href="SubmitLink.php">Submit Link</a></li>
        <li><a href="ExchangeLink.php">Exchange Link</a></li>
        <li><a href="LatestLinks.php">Latest Links</a></li>
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
			  <a style='color:#F6F6F6' href="admin.php">Admin Panel</a>
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
          <?php /////// displaying user info if user is logged
		  if (isset($_SESSION['MM_Username'])){?>
		  <li><a href="myAccount.php">My Account</a></li>
		  <?php }?>
            <a href="LinkDirectory.php">
              <li>Browse Links Directory</li>
            </a> <a href="SubmitLink.php">
    			<li>Submit Link - Free</li>
                </a> <a href="ExchangeLink.php">
                  <li>Exchange Link</li>
                  </a> <a href="AddFeatured.php">
                    <li>Add Featured Links</li>
                    </a> <a href="login.php">
                      <li>Login</li>
                      </a></ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <div class="panel">
        <div class="panelHeading">Help</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <a href="HowToSubmitLink.php">
              <li>How to Submit a link</li>
            </a> <a href="HowToExchange.php">
    			<li>How to Exchange link</li>
                </a> <a href="HowToManage.php">
                  <li>Managing Exchanged links</li>
                  </a> <a href="Tips.php">
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
            <a href="LinkSubmitRules.php">
              <li>Link Submittion Rules</li>
            </a> <a href="LinkExchangeRules.php">
    <li>Link Exchange Rules</li>
                </a> <a href="Privacy.php">
                  <li>Privacy Policy        </li>
                </a>
          </ul>
        </div>
        <!--panelBody ending div-->
      </div>
      <!--panel ending div-->
      <!--<label for="searchbar"></label>-->
    </div>
  <!--sidebar ending div. -->
  <div id="content">
    <div class="panel">
      <div class="panelBody">
        <h1>Exchange a Link:</h1>
        <p>Choose your Partner's Link:</p>
        <form name="formSelectCategory" id="formSelectCategory" method="post" action="ExchangeLink2.php">
        <table width="719">
  <tr>
    <td width="147" height="44" class="linksStyle">Select a Category:</td>
    <td width="560"><span id="spryselectCategory">
      <select name="DropdownListCategory" id="DropdownListCategory">
      <option value="-1">Please Choose One</option>
        <?php
do {  //displaying categories as values in dropdownlist//////////
?>
        <option value="<?php echo $row_RecordsetCategories['name']?>"><?php echo $row_RecordsetCategories['name']?></option>
        <?php
} while ($row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories));
  $rows = mysql_num_rows($RecordsetCategories);
  if($rows > 0) {
      mysql_data_seek($RecordsetCategories, 0);
	  $row_RecordsetCategories = mysql_fetch_assoc($RecordsetCategories);
  }
?>
      </select>
      <span class="selectInvalidMsg">Please select a valid item.</span><span class="selectRequiredMsg">Please select a Category.</span></span></td>
  </tr>
  <tr>
    <td><h4>Or </h4>
                <h4><a href="ExchangeLink3.php<?php echo "?all=1";?>">Show All Links</a></h4></td>
    <td><input name="next" type="submit" class="Button" id="next" value="Next" /></td>
  </tr>
</table>

        </form>
      </div>
      <!--panelBody ending div-->
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
          <?php /////// displaying admin panel if user is admin
		  if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
			  <a href="admin.php"><li>Admin</li></a>
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
      
      
Copyright &copy; <?php echo date('Y');?> All Rights Reserved

      </div><!--copright ending div. -->
  </div>
<p><!--footer ending div. --></p>
</div>
<!--container ending div. -->
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselectCategory", {invalidValue:"-1"});
</script>
</body>
</html>