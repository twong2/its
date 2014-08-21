<?php
    require('include/init.php');
    require_once ('include/functions.php');
    //print_r($_SESSION);
        $action = '';
        if (!empty($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        } // END if (!empty($_REQUEST['action']))

        $section = 'home';
        if (!empty($_REQUEST['section'])) {
            $section = $_REQUEST['section'];
        } // END if (!empty($_REQUEST['section']))
        
//        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
//        // last request was more than 30 minutes ago
//        session_unset();     // unset $_SESSION variable for the run-time 
//        session_destroy();   // destroy session data in storage
//        }
//        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
            
?>
<html>
<!--Home Page-->
    <head>
        <!-- 
        *~*~*~* PAGE TITLE *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~
        -->
        <title>ITS Services Mall</title>
        <style type="text/css" media="all">@import url("http://www.hawaii.edu/its/styles/2col_lefttopnav.css");</style>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    </head>
<body>
    <div class="ieminwidth">
        <div class="iecontainer">
            <div id="header">
                <div id="wrapper-header-left">
                    <a href="http://www.hawaii.edu/its/">
                        <img id="subits" title="Information Technology Services, University of Hawaii System" alt="Information Technology Services, University of Hawaii System" src="http://www.hawaii.edu/its/images/sub-logo-text.gif" />
                    </a>
                    <ul id="nav-top">
                        <!-- *~*~*~* TOP NAVIGATION *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~ -->
                        <li id="link-home"><a href="http://www.hawaii.edu/its/">HOME</a></li>
                        <li id="link-services"><a href="http://www.hawaii.edu/its/services.html">SERVICES</a></li>
                        <li id="link-status"><a href="http://www.hawaii.edu/its/status.php">STATUS</a></li>
                        <li id="link-about"><a href="http://www.hawaii.edu/its/about.html">ABOUT</a></li>    
                    </ul> <!-- nav-top -->
                </div> <!-- wrapper-header-left -->
                
                <div id="wrapper-header-right">
                    <ul id="link-up">
                        <li id="link-to-uh-home"><a href="http://www.hawaii.edu/">UH Home</a></li>
                        <li id="link-to-search-uh"><a href="http://www.hawaii.edu/search/">Search UH</a></li>
                    </ul> <!-- link-up -->
                </div> <!-- wrapper-header-right -->
            </div> <!-- header -->
        </div> <!-- iecontainer -->
    </div> <!-- ieminwidth -->
    <div id="wrapper-columns">
        <div id="left">
            
            
            <!-- ITS Service Mall -->
            <div id="its-service-mall"><a href="http://www.hawaii.edu/its/ecommerce/"></a>
            </div> <!-- ITS Service Mall -->
            
            <ul id="left-nav">
                <!-- 
                *~*~*~* LEFT NAVIGATION *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
                -->
                <li><a href="?section=index">HOME</a></li>
                <li><a href="?section=software">Software Design 1</a></li>
                <li><a href="?section=software2">Software Design 2</a></li>
                <li><a href="?section=services">Services</a></li>
                <li><a href="http://www.hawaii.edu/its/datacenter/services.php?cat=dc">Data Center Services Information</a></li>
                <li><a href="http://hawaii.edu/sitelic/">Site License Software Information</a></li>
                <li><a href="?section=faq">FAQ's</a></li>
                
                
                <!--Login button-->
                <li><?php if (!isUser()) { ?>
                <a href="<?php echo getCASServer() . '/cas/login?service=' . getCASLoginPage() . '?section=insertInfo'; ?>">
                    Login</a>
                <?php } else { ?>
                <a href="?section=insertInfo" class="account">Account Information</a>
                <a href="?section=viewCart">Shopping Cart</a>
                <!--<a href="?section=formPage" class="formLayout">Form Menu</a>-->
                <a href="?section=admin" class="userLink">Admin Menu</a>
                |
                <a href="<?php echo getCASServer() . '/cas/logout?service=' . getWebService() . '/logout.php'; ?>">
                    Logout <?php echo getUsername(); ?></a>
                <?php } // END if (!isUser()) ?>
                
                </li>
            </ul> <!-- left-nav -->
        </div>

                <?php
                require('include/links.php');
                ?>
            
    </div> <!-- wrapper-columns -->        
    <div id="footer">
        <div id="footer-left">
            <a href="http://www.hawaii.edu/"><img id="footer-uh-seal" src="http://www.hawaii.edu/its/images/footer-uh-seal.gif" height="55" width="55" title="University of Hawaii System Seal" alt="University of Hawaii System" /></a>
            <div id="usage-policy">Use of this site implies consent with our <a href="http://www.hawaii.edu/infotech/policies/itpolicy.html">Usage Policy</a></div>
            <div id="eeo">The University of Hawai&#145;i is an <a href="/site/policy/eoe.html">Equal Opportunity Employer</a></div>
            <div id="copyright">copyright &copy;2007 University of Hawai&#145;i</div>
        </div> <!-- footer-left -->
        
        <div id="footer-right">
            <a href="http://www.hawaii.edu/its/">
                <img id="footer-its-logo" src="http://www.hawaii.edu/its/images/footer-its-logo.gif" height="55" width="55" title="Information Technology Services Logo" alt="Information Technology Services" /></a>
            <ul>
                <li id="contact-its">
                    <a href="http://www.hawaii.edu/its/contact/">Contact ITS</a>
                </li>
                <li id="page-modified">This site is in development</li >
            </ul>
        </div> <!-- footer-right -->
    </div> <!-- footer -->
</body>
</html>