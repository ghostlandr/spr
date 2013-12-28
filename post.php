<?
include("session_start.php");
?>
<!DOCTYPE html>

<head>
<title>Saskatoon Police Report</title>

<link rel="stylesheet" type="text/css" href="spr.css">
</head>

<body>
    <div id="container">
        <div id="header">
            <div>
            <img src="img/logo.gif" alt="Saskatoon Police Report" id="banner_logo">
            </div>
            <div id="login">
            <?
                include("welcome_header.php");
            ?>
            </div>
        </div>
        <br clear="all">
        <div id="leftnav">
            <div class="menu_item"><span>About Us</span></div>
            <div class="menu_item"><span>News Archive</span></div>
            <div class="menu_item"><span>Inside Our Service</span></div>
            <div class="menu_item"><span>Programs &amp; Services</span></div>
            <div class="menu_item"><span>Recruiting</span></div>
            <div class="menu_item"><span>Online Reporting</span></div>
            <div class="menu_item"><span>Crime Mapping</span></div>
            <div class="menu_item"><span>Missing Persons</span></div>
            <div class="menu_item"><span>Wanted By Police</span></div>
            <div class="menu_item"><span>Can You Identify?</span></div>
            <div class="menu_item"><span>FAQ</span></div>
            <div class="menu_item"><span>New Headquarters</span></div>
            <div class="menu_item"><span>Social Media</span></div>
            <div class="menu_item"><span>Galleries</span></div>
            <div class="menu_item"><span>Downloads</span></div>
            <div class="menu_item"><span>Links</span></div>
        </div>
        <div id="content_noright">
            <h1>News Releases</h1>
        <?
        if(isset($_REQUEST['id']))
        {
            // Get post from database
            $postid = $_REQUEST['id'];
            $post_object = get_post_by_id($postid);
            // if it's approved
            if($post_object->is_approved())
            {
                echo $post_object->to_html_markup();
            }
            //      show it
            // else
            //      print "Not approved yet, how are you getting here?"
            //      if they are an admin while viewing
            //          show it anyway
            ?>
                <p>Admin functions</p>
        <?
        }
        else
        {
            // Get all posts
            // For each post
            //      echo this:
            ?>
            <div class="listed">
                <a href="post.php?id=$id">subject</a>
                <div style="float:right;" class="date_small">occurenceDate</div>
            </div>
            <?
        }
            ?>
            <br clear="all">
        </div>
        <div id="footer">
        This website is not affiliated whatsoever with the Saskatoon Police Service. I mean, come on, have you read the reports?<br>For more information, feel free to <a href="mailto:contact@saskatoonpolicereport.ca?Subject=I%20love%20your%20site" target="_top">Contact Us</a>.
        </div>
    </div>
    <div id="body_bg_top"></div>
    
    
</body>
</html>