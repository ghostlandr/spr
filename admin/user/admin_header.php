<div id="header">
    <div>
    <a href="../../"><img src="../../img/logo.gif" alt="Saskatoon Police Report" id="banner_logo"></a>
    </div>
    <div id="login">
    <?
        // This depends on session_start.php being included on a page
        if($user)
        {
            echo "Welcome $user->name! | "; 
            echo $user->user_can_post() ? "<a href='post.php?create'>Create Post</a> | " : "";
            echo "<a href='../../'>Index</a> | ";
            echo $user->is_approved() ? "<a href='../../archive.php'>Archives</a> | " : "";
            echo $user->is_approved_admin() ? "<a href='../../admin.php'>Admin</a> | " : "";
            echo "<a href='../../login.php?logout=true'>Logout</a>";
        }
        else
        {
            echo "<a href='../../login.php'>Login</a>";
        }
    ?>
    </div>
</div>
