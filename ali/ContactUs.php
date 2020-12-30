<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php 
 //Performing Server Side Form Validation IF JavaScript is Turned Off.
 $errors = array();
 $missing = array();
 if (isset($_POST['Submit'])){
	 	if (empty($_POST['fName'])){$missing['fName']=true;}
	 	if (empty($_POST['lName'])){$missing['lName']=true;}
		if (empty($_POST['subject'])){$missing['subject']=true;} 
	 	if (empty($_POST['email'])){$missing['email']=true;}
	 		else{	//Checks if email format is valid.
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$errors['InvalidEmail']=true;
					}
				}
		if (empty($_POST['fName'])){$missing['fName']=true;}
		if (empty($_POST['captchaValue'])){$missing['captchaValue']=true;}
	 		else{	//Checks if Entered Captcha is Wronge
				if($_POST['captchaValue'] != $_SESSION['randomnr2']){
				$errors['wrongCaptcha']=true;
				}
			}
 		}
	 ?>
<?php 
	 if(isset($_POST['Submit'])){ 
	 //checks if there are no errors of missing then send message to admin.
			if((count($missing)==0)&&(count($errors)==0)){
				$userName = $_POST['fName'];
				$userName .= " ".$_POST['lName'];
				$to = "demo@localhost.com";/////////here admin email address will be used while deploying  
				$from = $_POST['email'];
				$subject = $_POST['subject'];
				$message = $_POST['message'];
				// In case any of our lines are larger than 70 characters, we should use wordwrap()
				$message = wordwrap($message, 70, "\r\n");
				$headers = 'From:'.$userName."<".$from.">" ;
				// sending mail
				if(mail($to, $subject, $message, $headers)){
					$result = "Email Sent..";}
				else {
					$result = "Sending Failed";
					}
				
			}
		}?>

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
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
            <a href="/LinkDirectory.php">
            <li>Browse Links Directory</li>
            </a> <a href="/SubmitLink.php">
            <li>Submit Link - Free</li>
            </a> <a href="/ExchangeLink.php">
            <li>Exchange Link</li>
            </a> <a href="/AddFeatured.php">
            <li>Add Featured Links</li>
            </a> <a href="/login.php">
            <li>Login</li>
            </a> <a href="/Signup.php">
            <li>Register</li>
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
    <div id="content">
      <div class="panel">
        <div class="panelBody">
          <h1>Contact Us:</h1>
          <table border="0" width="99%" cellpadding="4" id="table1" cellspacing="4">
            <tbody>
              <tr>
                <td>If You want to make your link as <strong>featured link</strong> in our link directory or do you have a problem, question, suggestion or tips.<br />
                  We welcome and value your feedback about our link directory and link Exchange services.</td>
              </tr>
              <tr></tr>
            </tbody>
          </table>
          <br />
          <p><strong>Please use the form below to contact us..</strong></p>
          <?php if(isset($result)){ echo "<span style=\"color:#F00\">".$result."</span>";}//Displaying email submission result.?>
          <form id="formContactUs" name="formContactUs" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <table width="680" align="center">
              <tr>
                <td width="146"><h4>
                    <label for="fName">First Name:</label>
                  </h4></td>
                <td width="553"><span id="sprytextfieldFName">
                  <input name="fName" type="text" id="fName" size="30" maxlength="30"
                  <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['fName']."\"";
			   }//Restoring Previous Value if Any errors or Missing are there....?>/>
                  <?php if(isset($missing['fName'])){
				   echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <span class="textfieldRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr>
                <td><h4>
                    <label for="lName">Last Name:</label>
                  </h4></td>
                <td><span id="sprytextfieldLName">
                  <input name="lName" type="text" id="lName" size="30" maxlength="30" 
                <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['lName']."\"";
			   }//Restoring Previous Value if Any errors or Missing are there....?>
                />
                  <?php if(isset($missing['lName'])){
				   echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <span class="textfieldRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr>
                <td><h4>
                    <label for="email">Email:</label>
                  </h4></td>
                <td><span id="sprytextfieldEmail">
                  <input name="email" type="text" id="email" size="30" maxlength="30" 
               <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['email']."\"";
			   }//Restoring Previous Value if Any errors or Missing are there....?>
              />
                  <?php if(isset($missing['email'])){
				  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <?php if(isset($errors['InvalidEmail'])){
					  echo "<span style=\"color:#F00\">Invalid Email.</span>";}//Display Error Message.?>
                  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid Email format.</span></span></td>
              </tr>
              <tr>
                <td><h4>Subject:</h4></td>
                <td><span id="sprytextfieldSubject">
                  <input name="subject" type="text" id="subject" size="30" maxlength="30" 
                  <?php if((count($missing)>0)||(count($errors)>0)){
			   echo "value=\"".$_POST['subject']."\"";
			   }//Restoring Previous Value if Any errors or Missing are there....?>
               />
                  <?php if(isset($missing['subject'])){
				  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <span class="textfieldRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr>
                <td><h4>
                    <label for="message">Message</label>
                    :</h4></td>
                <td><span id="sprytextareaMessage">
                  <textarea name="message" id="message" cols="45" rows="5"><?php if((count($missing)>0)||(count($errors)>0)){echo $_POST['message'];}
				  //Restoring Previous Value if Any errors 	or Missing are there....?>
                </textarea>
                  <?php if(isset($missing['message'])){
				  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <span class="textareaRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr>
                <td><h4>Captcha:</h4></td>
                <td><img src="capcha/Captcha.php"/></td>
              </tr>
              <tr>
                <td><h4>Enter Captcha Value:</h4></td>
                <td><span id="sprytextfieldCaptchaVal">
                  <input name="captchaValue" type="text" id="captchaValue" size="30" maxlength="30" />
                  <?php if(isset($missing['captchaValue'])){
				  echo "<span style=\"color:#F00\">Missing.</span>";}//Display Error Message.?>
                  <?php if(isset($errors['wrongCaptcha'])){
				  echo "<span style=\"color:#F00\">Captcha Value Incorrect.</span>";}//Display Error Message.?>
                  <span class="textfieldRequiredMsg">A value is required.</span></span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="Submit" type="submit" class="Button" id="Submit" value="Submit" /></td>
              </tr>
            </table>
          </form>
        </div>
        <!--panelBody ending div--> 
      </div>
      <!--panel ending div--> 
    </div>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfieldFName");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfieldLName");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfieldEmail", "email");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextareaMessage");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfieldCaptchaVal");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfieldSubject");
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