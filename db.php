<?php
/**
 * 
 * @param  [type] $sql
 * @param  [type] $bind_string
 * @param  array $bind_params_array
 * @return [type]
 */
function do_prepared_statement_by_sql($sql, $bind_string, $bind_params_array)
{
    $db = get_localhost_connection();
    $params_by_reference = array();
    $num_params = count($bind_params_array);
    $params_by_reference[] = & $bind_string;
    for($i = 0; $i < $num_params; ++$i)
    {
        $params_by_reference[] = & $bind_params_array[$i];
    }
    if($stmt = $db->prepare($sql))
    {
        // http://php.net/manual/en/function.call-user-func-array.php
        // This function is disgustingly cool, lol.
        // For it to work, the first array must pass this condition:
        //      is_callable(array($stmt, "bind_param")) == true
        // The second array must contain the references to parameters
        call_user_func_array(array($stmt, "bind_param"), $params_by_reference);
        if(!$stmt->execute())
        {
            return false;
        }
        $stmt->close();
    }
    $db->close();
    // If we got here, we succeeded
    return true;
}

/**
 * Connects to the database and returns the mysqli object for use in commands like
 * $obj->prepare() and etc.
 * @return mixed Will return a mysqli object if it connected successfully, otherwise false
 */
function get_database_connection($hostname="", $user="", $password="", $database="")
{
    $mysqli = new mysqli($hostname, $user, $password, $database);
    // If there was an error, return false, otherwise pass the object itself
    return $mysqli->connect_errno ? false : $mysqli;
}

function get_localhost_connection()
{
    return get_database_connection("127.0.0.1", "root", "mysql", "spr");
}
