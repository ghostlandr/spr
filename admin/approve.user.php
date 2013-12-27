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
                echo "<h2>Approve users</h2>";
                if(isset($_REQUEST["id"]))
                {
                    $userid = $_REQUEST["id"];
                    $user_object = get_user_from_db_by_id($userid);
                    if(!$user_object->is_approved())
                    {
                        $user_approved = approve_user($userid);
                        if($user_approved)
                        {
                            echo "<p>Okay, $user_object->name has been approved.</p>";
                        }
                    }
                }

                $unapproved = get_unapproved_users();
                
                if($unapproved)
                {
                    echo "<table border=1>
                            <tr><th>User's Name</th><th>Username</th><th>Email</th><th>Account Type</th><th>Approve?</th>";
                    foreach($unapproved as $id=>$user)
                    {
                        echo "<tr>
                                <td>".$user['name']."</td>
                                <td>".$user['username']."</td>
                                <td>".$user['email']."</td>
                                <td>".$user['account_type']."</td>
                                <td><button onclick='confirmApprove($id)'>Approve</button></td>
                              </tr>";
                    }
                    echo "</table>";
                }
                else
                {
                    echo "<p>Nothing to do! Kick your feet up, you sexy beast.</p>";
                }

            }

            echo "<p><a href='../admin.php'>Go back to the other admin functions</a></p>";
        ?>
            <br clear="all">
        </div>
        <div id="footer">
        This website is not affiliated whatsoever with the Saskatoon Police Service. I mean, come on, have you read the reports?<br>For more information, feel free to <a href="mailto:contact@saskatoonpolicereport.ca?Subject=I%20love%20your%20site" target="_top">Contact Us</a>.
        </div>
    </div>
    <div id="body_bg_top"></div>
    
    <script type='text/javascript'>
        var confirmApprove = function(userid){
            if(confirm("Are you sure you want to approve this person?")) {
                window.location.assign('approve.user.php?id=' + userid);
            }
        };
    </script>
</body>
</html>
