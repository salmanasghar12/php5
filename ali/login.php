<?php require_once('Connections/seoExchangeDbConnection.php'); ?>
<?php if(!isset($_SESSION)){ 	// Redirect User to AlreadyLogged.php page if User Already Logged.
	session_start();
	if(isset($_SESSION['MM_Username'])){
		 header('Location: alreadyLogged.php');
		 }
	}
	?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['TextBoxUsername'])) {
  $loginUsername=$_POST['TextBoxUsername'];
  $password=$_POST['TextBoxPassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "myAccount.php";
  $MM_redirectLoginFailed = "loginFailed.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_seoExchangeDbConnection, $seoExchangeDbConnection);
  /////////////////////////checking if entered username and password is found in database //////////////////
  $LoginRS__query=sprintf("SELECT id, username, password FROM users WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $seoExchangeDbConnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
	 $row_LoginRS = mysql_fetch_assoc($LoginRS);
	 $userId = $row_LoginRS['id'];
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['MM_UserId'] = $userId;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  /////////redirecting user if loginfailed page if loging failed...
    header("Location: ". $MM_redirectLoginFailed );
  }
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
<link href="Styles/login.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
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
          <?php  /////// displaying user info if user is logged
		  if (isset($_SESSION['MM_Username'])){?>
          <li><a href="../myAccount.php">My Account</a></li>
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
    <div class="panel" >
      <div class="panelBody">
        <?php 
		if(isset($_SESSION['LoginFirst'])){ //Checks if user redirected from Rectricted page and displays error
			unset($_SESSION['LoginFirst']);
			echo "<p style=\"color:#F00\">Please Login First.</p>";}?>
        <h1>User Login</h1>
        <div id="LoginDiv" >
          <form id="LoginForm" name="LoginForm" method="POST" action="<?php echo $loginFormAction; ?>">
            <table width="487" height="203" border="0">
              <tr>
                <td width="113" height="46"><h4>Username:</h4></td>
                <td width="364"><span id="sprytextfieldUsername">
                  <input name="TextBoxUsername" type="text" id="TextBoxUsername" size="30" />
                  <span class="textfieldRequiredMsg">Username is required.</span></span></td>
              </tr>
              <tr>
                <td height="40"><h4>Password:</h4></td>
                <td><span id="spryPassword">
                  <input name="TextBoxPassword" type="password" id="TextBoxPassword" size="30" maxlength="30" />
                  <span class="passwordRequiredMsg">Password 
                  is required.</span></span></td>
              </tr>
              <tr>
                <td height="56">&nbsp;</td>
                <td><input name="ButtonSubmit" type="submit" class="Button" id="ButtonSubmit" value="Submit" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><a href="passwordRecovery.php">Forgot Password?  Click here.</a></td>
              </tr>
            </table>
            
            <!--LoginDiv ending-->
          </form>
        </div>
        <div id="signup">
          <h3>New Member:</h3>
          <p><a href="/Signup.php">Click Here for Signup</a></p>
        </div>
        <!--signup div ending--> 
      </div>
      <!--panelBody ending div--
      </div>
    <!--panel ending div--> 
    </div>
    <script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldUsername", "none");
var sprypassword1 = new Spry.Widget.ValidationPassword("spryPassword");
  </script><!--content ending div. --> 
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
        <?php	/////// displaying admin panel if user is admin
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