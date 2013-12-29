<?php
/**
 * 
 * @param  [type] $sql
 * @param  [type] $bind_string
 * @param  array $bind_params_array
 * @return [type]
 */
function do_prepared_statement_by_sql($sql, $bind_params_array)
{
    $db = get_database_connection();

    if($stmt = $db->prepare($sql))
    {
        // http://php.net/manual/en/function.call-user-func-array.php
        // This function is disgustingly cool, lol.
        // For it to work, the first array must pass this condition:
        //      is_callable(array($stmt, "bind_param")) == true
        // The second array must contain the references to parameters
        call_user_func_array(array($stmt, "bind_param"), $bind_params_array);
        if(!$stmt->execute())
        {
            $db->close();
            return false;
        }
        $stmt->close();
    }
    else
    {
        $db->close();
        return false;
    }
    $db->close();
    // If we got here, we succeeded
    return true;
}

function do_prepared_insert_statement_by_sql($sql, $bind_params_array)
{
    $db = get_database_connection();
    $insertid = 0;
    if($stmt = $db->prepare($sql))
    {
        // http://php.net/manual/en/function.call-user-func-array.php
        // This function is disgustingly cool, lol.
        // For it to work, the first array must pass this condition:
        //      is_callable(array($stmt, "bind_param")) == true
        // The second array must contain the references to parameters
        call_user_func_array(array($stmt, "bind_param"), $bind_params_array);
        if(!$stmt->execute())
        {
            $db->close();
            return false;
        }
        $insertid = $stmt->insert_id;
        $stmt->close();
    }
    else
    {
        $db->close();
        return false;
    }
    $db->close();
    // If we got here, we succeeded
    return $insertid;
}

function do_prepared_statement_by_sql_and_return_first_result($sql, $bind_params_array, $bind_results_array)
{
    $db = get_database_connection();

    if($stmt = $db->prepare($sql))
    {
        // http://php.net/manual/en/function.call-user-func-array.php
        // This function is disgustingly cool, lol.
        // For it to work, the first array must pass this condition:
        //      is_callable(array($stmt, "bind_param")) == true
        // The second array must contain the references to parameters
        call_user_func_array(array($stmt, "bind_param"), $bind_params_array);
        if(!$stmt->execute())
        {
            $db->close();
            return false;
        }
        call_user_func_array(array($stmt, "bind_result"), $bind_results_array);

        // Important to fetch to fill the bound results variables
        $stmt->fetch();
        $stmt->close();
    }
    else
    {
        $db->close();
        return false;
    }
    $db->close();
    // If we got here, we succeeded
    return true;
}

function get_fields_from_table($tablename, $fields="*", $where="", $orderby="", $limit="")
{
    $db = get_database_connection();
    $sql = "SELECT $fields FROM $tablename $where $orderby $limit";
    $results = $db->query($sql);
    $return_set = array();
    while($row = $results->fetch_assoc())
    {
        // TODO: Better way to get primary id
        $return_set[$row['id']] = $row;
    }
    $db->close();
    return $return_set;
}

/**
 * Connects to the database and returns the mysqli object for use in commands like
 * $obj->prepare() and etc.
 * @return mixed Will return a mysqli object if it connected successfully, otherwise false
 */
function get_database_connection($hostname="", $user="", $password="", $database="")
{
    $mysqli = null;
    if(strstr($_SERVER['SERVER_NAME'], "localhost"))
    {
        $mysqli = get_localhost_connection();
    }
    else if($hostname == "")
    {
        $mysqli = new mysqli("localhost", "sprints_spr", "R3sisting!!", "sprints_spr_db");
    }
    else
    {
        $mysqli = new mysqli($hostname, $user, $password, $database);
    }
    // If there was an error, return false, otherwise pass the object itself
    return $mysqli->connect_errno ? false : $mysqli;
}

function get_localhost_connection()
{
    return new mysqli("127.0.0.1", "root", "mysql", "spr");
}
