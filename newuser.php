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
        <?
        if(isset($_POST['username']))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['name'];
            $type = $_POST['type'];

            $new_user_id = add_user_to_db($username, $password, $email, $name, $type);
            if($new_user_id)
            {
                echo "<p>Your account has been created. Keep an eye on your email! <a href='login.php'>Click here</a> to login now.</p>";
                if($type == ADMIN)
                {
                    echo "<p>You will need to be approved before your Admin priveleges come into effect.</p>";
                }
                else
                {
                    echo "<p>You will need to be approved before you can see the archives.</p>";
                }
            }
            else
            {
                echo "<p>Something went wrong... <a href='newuser.php'>Try again?</a></p>";
            }
        }
        else
        {
        ?>
            <h2>New User</h2>
            <form method="POST" action="newuser.php" onsubmit="return validateForm()">
            <table>
                <tr>
                    <td><label for="username">Username</label></td>
                    <td><input type="text" name="username" id="username" required /></td>
                </tr>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td><input type="email" name="email" id="email" required /></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td><input type="password" name="password" id="password" required /></td>
                </tr>
                <tr>
                    <td><label for="repeatPassword">Re-enter Password</label></td>
                    <td><input type="password" name="repeatPassword" id="repeatPassword" required /></td>
                </tr>
                <tr>
                    <td><label for="name">Your first name</label></td>
                    <td><input type="text" name="name" id="name" required /></td>
                </tr>
                <tr>
                    <td><label for="type">Account type</label></td>
                    <td><select id="type" name="type" required>
                        <option value=''>---</option>
                        <option value='admin'>Admin</option>
                        <option value='user'>User</option>
                    </select></td>
                </tr>
                <tr>
                    <td colspan='2'><input type='submit' /></td>
                </tr>
            </table>
            </form>
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
    
    <script type='text/javascript'>
        var validateForm = function(){
            var pass1 = document.getElementById("password");
            var pass2 = document.getElementById("repeatPassword");
            if(pass1.value == pass2.value && pass1.value != "") {
                return true;
            }
            else {
                alert("The passwords must be the same!");
                pass2.focus();
                return false;
            }
        };
    </script>
</body>
</html>
