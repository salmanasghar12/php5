<?php
//initialize the session
if (!isset($_SESSION)) {
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
              <li>Link Submission Rules</li>
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
        <h1>Managing your Exchanged Links ?</h1>
  <p><a href="ExchangeLink.php">Link Exchange</a> and Management of <a href="MyExchangedLinks.php">Exchanged links</a> and <a href="myLinks.php">submitted link</a>  are Services for our Registered Users only, so if you not our Registered user, goto <a href="Signup.php">here</a> to get registered to avail our services.</p>
        <p>Your can manage your exchanged links by going to <a href="MyExchangedLinks.php">My Exchanged Links</a> which will show your exchanged links along with Status and other information of your Exchanged links. </p>
        <p>An Active* Status shows that exchange link is also active by other side that is, from your partner side. To Remove Exchanged, choose your desired Exchanged link and click Remove. After that, your Desired Exchanged link will be removed from your Exchanged links list.  An E-mail notification will be sent to inform your partner.</p>
        <p>&nbsp;</p>
        <p>* <strong>note: </strong>Since we don't provide any type of mechanism to check, embed or remove your partner's link into your website or vice versa, so you have to explicitly embed/Remove your partner's link into your website and to <strong>check</strong> weather your partner has embedded/ removed your link from his/her side.</p>
        <p></p>
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