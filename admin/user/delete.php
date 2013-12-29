<?
include("../../session_start.php");
?>
<!DOCTYPE html>

<head>
<title>Saskatoon Police Report</title>

<link rel="stylesheet" type="text/css" href="../../spr.css">
</head>

<body>
    <div id="container">
        <?
        include("admin_header.php");
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
            if($user->is_approved_admin())
            {
                echo "<h1>Admin functions</h1>";
                echo "<h2>Delete users</h2>";
                if(isset($_REQUEST["id"]))
                {
                    $userid = $_REQUEST["id"];
                    $user_object = get_user_from_db_by_id($userid);
                    if(!$user_object->is_deleted())
                    {
                        $user_deleted = delete_user($userid);
                        if($user_deleted)
                        {
                            echo "<p>Okay, $user_object->name has been deleted.</p>";
                        }
                    }
                    else
                    {
                        echo "<p>You're trying to delete a user with an id of $userid,
                         but they're already deleted.</p>";
                    }
                }

                $deleting = get_all_users();
                
                echo "<table border=1>
                        <tr><th>User's Name</th><th>Username</th><th>Email</th><th>Account Type</th><th>Delete?</th>";
                foreach($deleting as $id=>$deleting_user)
                {
                    echo "<tr>
                            <td>".$deleting_user['name']."</td>
                            <td>".$deleting_user['username']."</td>
                            <td>".$deleting_user['email']."</td>
                            <td>".$deleting_user['account_type']."</td>";
                    if($user->is_same_id($id))
                    {
                        echo "<td>This is you! D:</td>";
                    }
                    else
                    {
                        echo "<td><button onclick='confirmDelete($id)'>Delete</button></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

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
        var confirmDelete = function(userid){
            if(confirm("Are you sure you want to delete this person? This action cannot be undone.")) {
                window.location.assign('delete.php?id=' + userid);
            }
        };
    </script>
</body>
</html>
