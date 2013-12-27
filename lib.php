<?php
require_once("db.php");
require_once("user.php");

define("ADMIN", "admin");
define("USER", "user");
define("APPROVED", 1);

function add_user_to_db($username, $password, $email, $name, $account_type)
{
    $db = get_localhost_connection();
    $userid = 0;
    $hashed_password = md5($password);
    if($stmt = $db->prepare("INSERT INTO user (username, password, email, name, account_type) VALUES(?, ?, ?, ?, ?)"))
    {
        $stmt->bind_param("sssss", $username, $hashed_password, $email, $name, $account_type);
        if(!$stmt->execute())
        {
            // Something didn't work
            return false;
        }
        $userid = $stmt->insert_id;
        $stmt->close();
    }
    $db->close();
    // If we got here, insertion succeeded
    return $userid != 0 ? true : false;
}

function approve_user($userid)
{
    $sql = "UPDATE user SET approved = 1 WHERE id = ?";
    return do_prepared_statement_by_sql($sql, "i", array($userid));
}

function delete_user($userid)
{
    $sql = "DELETE FROM user WHERE id = ?";
    return do_prepared_statement_by_sql($sql, "i", array($userid));
}

function get_all_users()
{
    $db = get_localhost_connection();
    $sql = "SELECT id, username, email, name, account_type, created FROM user";
    $results = $db->query($sql);
    $users = array();
    while($row = $results->fetch_assoc())
    {
        $users[$row['id']] = $row;
    }
    $db->close();
    return $users;
}

function get_unapproved_users()
{
    $db = get_localhost_connection();
    $sql = "SELECT id, username, email, name, account_type, created FROM user WHERE approved = 0";
    $results = $db->query($sql);
    $users = array();
    while($row = $results->fetch_assoc())
    {
        $users[$row['id']] = $row;
    }
    $db->close();
    return $users;
}

function get_user_from_db($username, $password)
{
    $db = get_localhost_connection();
    $user_object = null;
    $hashed_password = md5($password);
    if($stmt = $db->prepare("SELECT * FROM user WHERE username=? AND password=?"))
    {
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->bind_result($id, $dbusername, $dbpassword, $email, $name, $type, $created, $logins);
        $stmt->fetch();
        $user_object = new User($dbusername, $dbpassword, $email, $name, $type, $created, $logins, $id);
        $stmt->close();
    }
    $db->close();

    return $user_object ? $user_object : false;
}

function get_user_from_db_by_id($userid, $as_user_object=true)
{
    $db = get_localhost_connection();

    $user_object = null;
    if($stmt = $db->prepare("SELECT * FROM user WHERE id=?"))
    {
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($id, $dbusername, $dbpassword, $email, $name, $type, $created, $approved);
        $stmt->fetch();
        if($as_user_object)
        {
            $user_object = new User($dbusername, $dbpassword, $email, $name, $type, $created, $approved, $id);
        }
        else
        {
            $user_object = array("username"=>$dbusername,
                                 "email"=>$email,
                                 "name"=>$name,
                                 "account_type"=>$type,
                                 "created"=>$created,
                                 "approved"=>$approved,
                                 "id"=>$id);
        }
        $stmt->close();
    }
    $db->close();

    return $user_object ? $user_object : false;
}

function is_valid_user($username, $password)
{
    // Connect to database
    $db = get_localhost_connection();
    // Set this for later
    $userid = 0;
    $hashed_password = md5($password);
    if($stmt = $db->prepare("SELECT id FROM user WHERE username=? AND password=?"))
    {
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $userid = $id;
        $stmt->close();
    }
    $db->close();

    return $userid != 0 ? true : false;
}

function send_email($recipient_email, $subject, $body)
{
    $sender_name = "SPR";
    $sender_email = "contact@saskatoonpolicereport.ca";
    $header = "From: $sender_name <$sender_email>\r\n";
    mail($recipient_email, $subject, $body, $header);
}

function send_welcome_email($username, $message="", $subject="")
{
//     $db = get_localhost_connection();
//     $useremail = "";

//     if($stmt = $db->prepare("SELECT email FROM user WHERE username=?"))
//     {
//         $stmt->bind_param("s", $username);
//         $stmt->execute();
//         $stmt->bind_result($email);
//         $useremail = $email;
//         $stmt->fetch();
//         $stmt->close();
//     }

//     if($useremail != "")
//     {
//         $subject = "Welcome to Saskatoon Police Reports";
//         $body = "
// <h2>Welcome!</h2>
// <p>You're getting this email because you created an account on <a href='saskatoonpolicereport.ca'>saskatoonpolicereport.ca</a>. Here is your information:</p>
// <ul>
//     <li>Username: $username</li>
// </ul>
// <p>Signed, your friends at SPR.</p>";
//         send_email($useremail, $subject, $body);
//         return true;
//     }
    
    return true;
}

function update_user($userid, $username, $email, $approved)
{
    $sql = "UPDATE user SET username = ?, email = ?, approved = ? WHERE id = ?";
    return do_prepared_statement_by_sql($sql, "ssss", array(&$username, &$email, &$approved, &$userid));
}
