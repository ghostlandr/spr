<?
// This depends on session_start.php being included on a page
if($user)
{
    echo "Welcome $user->name! | "; 
    echo "<a href='./'>Index</a> | ";
    echo $user->is_approved() ? "<a href='archive.php'>Archives</a> | " : "";
    echo $user->is_approved_admin() ? "<a href='admin.php'>Admin</a> | " : "";
    echo "<a href='login.php?logout=true'>Logout</a>";
}
else
{
    echo "<a href='login.php'>Login</a>";
}
