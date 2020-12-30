<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php
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
////////////////////////////   Getting Password and Email of user entered username  /////////////////
// 
if (isset($_POST['Recover'])){
mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
$query_RecordsetUser = sprintf("SELECT password, email FROM users WHERE username = %s", GetSQLValueString($_POST['username'], "text"));
$RecordsetUser = mysql_query($query_RecordsetUser, $seoExchangeDbConnection) or die(mysql_error());
$row_RecordsetUser = mysql_fetch_assoc($RecordsetUser);
$totalRows_RecordsetUser = mysql_num_rows($RecordsetUser);
if ($totalRows_RecordsetUser){
	//////////////////  sending mail   ///////////////////////////////
	$to = $row_RecordsetUser['email'];
	$subject = "SeoExchange: Your Request for Password Recovery";
	$message = "This is in response to your request for Password Recovery.\n \nYour Password: ".$row_RecordsetUser['password']."\n\n Thank You \n \n";
		if(mail($to, $subject, $message)){
			$mailSent = "Your password is posted to your emil address: \"".$to."\" <br/>Please check your mail after some time.";
			}
	}
else{
	$errors['notFound']=true;
	}//username not found in database
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeoExchange.com</title>
<script type="text/javascript" src="Scripts/HomePage.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css"></style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
<div id="container">
  <div id="header">
    <div id="logo"> <a href="index.php"><img src="images/Logo SEO Exchange.png" width="268" height="58" alt="seo Exchange Logo" longdesc="index.php" border="none;"/></a></div>
    <!--logo ending div. -->
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
    <div id="DivUserWelcome">
      <?php /////// displaying user info if user is logged
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
    </div>
    <!--searchbar ending div. --> 
  </div>
  <!--header ending div. -->
  
  <div id="main">
    <div id="sidebar">
      <div class="panel">
        <div class="panelHeading">Common Tasks</div>
        <!--panelHeading ending div-->
        <div class="panelBody">
          <ul>
            <?php /////// displaying user account if user is logged
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
            </a>
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
            <li>Privacy Policy </li>
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
          <h1>Password Recovery:</h1>
          <p>Please enter your username below and press recover button.</p>
          <form id="formPasswordRecovery" name="formPasswordRecovery" 
        method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <table width="656">
              <tr>
                <td width="131" height="39"><h4>Username:</h4></td>
                <td width="513"><span id="sprytextfieldUsername">
                  <input type="text" name="username" id="username" />
                  <span class="textfieldRequiredMsg">Username is required.</span></span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="Recover" type="submit" class="Button" id="Recover" value="Recover" /></td>
              </tr>
            </table>
          </form>
          <p style="color:#0344a8">
            <?php if (isset($mailSent)){echo $mailSent;}?>
          </p>
          <p style="color:#F00">
            <?php if (isset($errors['notFound'])){
			echo "Sorry Your Entered Username is not there in our database . You can signup and login to use our site.";}?>
          </p>
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
    </div>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldUsername");
  </script> 
    <!--content ending div. --> 
  </div>
  <!--main ending div. -->
  
  <div id="footer">
    <div id="footnav">
      <ul>
        <a href="index.php">
        <li>Home Page</li>
        </a> <a href="LinkDirectory.php">
        <li>link directory</li>
        </a> <a href="SubmitLink.php">
        <li>submit link</li>
        </a> <a href="ExchangeLink.php">
        <li>exchange link</li>
        </a> <a href="Signup.php">
        <li>signup</li>
        </a> <a href="login.php">
        <li>Login</li>
        </a>
        <?php /////// displaying admin panel if user is admin
		if(isset($_SESSION['MM_Username'])&&($_SESSION['MM_Username']=='admin')){?>
        <a href="admin.php">
        <li>Admin</li>
        </a>
        <?php }?>
      </ul>
    </div>
    <!--footnav ending div. -->
    <div id="footcontent">
      <ul>
        <a href="AboutUs.php">
        <li>About Us</li>
        </a> <a href="ContactUs.php">
        <li>Contact Us</li>
        </a> <a href="TermConditions.php">
        <li>Terms & Condition</li>
        </a> <a href="Privacy.php">
        <li>Privacy Policy</li>
        </a> <a href="index.php">
        <li>Sitemap</li>
        </a>
      </ul>
    </div>
    <!--footcontent ending div. -->
    <div id="copyright"> 
      
      <!--	dynamically changing year--> 
      Copyright &copy; <?php echo date('Y');?> All Rights Reserved </div>
    <!--copright ending div. --> 
  </div>
  <p><!--footer ending div. --></p>
</div>
<!--container ending div. --> 
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($RecordsetUser);
?>
