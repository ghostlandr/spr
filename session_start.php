<?
session_start();
// Start the session and include the library functions (which require the others)
require_once("lib.general.php");

$user = null;
if(isset($_SESSION["user"]))
{
    $user = unserialize($_SESSION["user"]);
}
