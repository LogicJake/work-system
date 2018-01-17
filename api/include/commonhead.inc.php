<?

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

if(!isset($_SESSION)){
    session_start();
}

require_once './include/Medoo.php';
require_once './include/config.php';

require_once './include/result.class.php';

require_once './include/request.class.php';
Request::initialize();

/*
ini_set("display_errors", "On");

error_reporting(E_ALL | E_STRICT);
*/
