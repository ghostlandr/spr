<?
include("../session_start.php");
?>
<!DOCTYPE html>

<head>
<title>Saskatoon Police Report</title>

<link rel="stylesheet" type="text/css" href="../spr.css">
</head>

<body>
    <div id="container">
        <div id="header">
            <div>
            <img src="../img/logo.gif" alt="Saskatoon Police Report" id="banner_logo">
            </div>
            <div id="login">
            <?php
            include("admin_header.php");
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
        <?
            if($user->is_approved_admin())
            {
                echo "<h1>Admin functions</h1>";
                echo "<h2>Change user information</h2>";

                if(isset($_POST["id"]))
                {
                    $id_to_update = $_POST["id"];
                    $username = $_POST["username"];
                    $email = $_POST["email"];
                    $approved = $_POST["approved"];
                    if(update_user($id_to_update, $username, $email, $approved))
                    {
                        echo "<p>Information updated successfully</p>";
                    }
                }

                if(isset($_GET["id"]))
                {
                    $userid = $_REQUEST["id"];
                    $user_object = get_user_from_db_by_id($userid, false);
                    if($user->is_same_id($userid))
                    {
                        echo "<p><strong>This is you! Carry on... but be warned. There may
                         be some session issues until you log out and log back in again.</strong></p>";
                    }
                    echo "<table border=1><form method='POST' action='edit.user.php?id=$userid'>
                            <tr><th>Field</th><th>Value</th></tr>";
                    echo "<tr><td>Username</td><td><input type='text' name='username' value='".$user_object['username']."'/></td></tr>";
                    echo "<tr><td>Email</td><td><input type='email' name='email' value='".$user_object['email']."'/></td></tr>";
                    echo "<tr><td>Created Date</td><td>".$user_object['created']."</td></tr>";
                    echo "<tr><td>Approved</td><td><input type='text' name='approved' value='".$user_object['approved']."'/>";
                    echo "      <input type='hidden' name='id' value='".$user_object['id']."'/></td></tr>";
                    // "username"=>$dbusername,
                    //              "email"=>$email,
                    //              "name"=>$name,
                    //              "account_type"=>$type,
                    //              "created"=>$created,
                    //              "approved"=>$approved,
                    //              "id"=>$id
                    echo "<tr><td colspan=2><input type='submit'/></td></tr>";
                    echo "</form></table>";
                }
            }

            echo "<p><a href='change.user.php'>Go back to user list</a></p>";
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
