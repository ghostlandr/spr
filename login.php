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
        <?
        include("welcome_header.php");
        ?>
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
        <?php
            if(isset($_REQUEST["logout"]))
            {
                // Destroy the user variable, any cookies
                unset($_SESSION["user"]);
                echo "<p>You have been logged out... redirecting to the home page. <a href='index.php'>Click here</a> if this takes more than a second.</p>";
                echo "<script type='text/javascript'>window.setTimeout('window.location.assign(\'index.php\')', 500);</script>";
                // cookie()
            }
            else if(isset($_SESSION["user"]))
            {
                $user = unserialize($_SESSION["user"]);
                echo "<p>You are already logged in as $user->name... not you?";
                echo " then <a href='login.php?logout=true'>click here</a> to log out.<p>";
            }
            else if(isset($_POST["username"]))
            {
                $username = $_POST["username"];
                $password = $_POST["password"];
                if(is_valid_user($username, $password))
                {
                    $user = get_user_from_db($username, $password);
                    if($user)
                    {
                        $_SESSION["user"] = serialize($user);
                        echo "<p>You're logged in, redirecting you now...<a href='index.php'>Click here</a> if this takes more than a second.</p>";
                        echo "<script type='text/javascript'>window.setTimeout('window.location.assign(\'index.php\')', 500);</script>";
                    }
                    else
                    {
                        echo "<p>Something went very wrong.</p>";
                    }
                }
                else
                {
                    echo '
                        <h2>Login failed!</h2>
                        <div id="login-form">
                        <form method="POST" action="login.php">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required />
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required />
                            <input type="submit" />
                        </form>
                        </div>
                        <p>Don\'t have an account? Feel free to 
                        <a href="mailto:contact@saskatoonpolicereport.ca?Subject=You+suck">email us</a> and complain...
                        maybe you\'ll get an account.</p>
                    ';
                }
            }
            else
            {
                echo '
                <h2>Login</h2>
                <div id="login-form">
                <form method="POST" action="login.php">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required />
                    <input type="submit" />
                </form>
                </div>
                <p>Don\'t have an account? Feel free to 
                <a href="mailto:contact@saskatoonpolicereport.ca?Subject=You+suck">email us</a> and complain...
                maybe you\'ll get an account.</p>
                ';
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
<html>
