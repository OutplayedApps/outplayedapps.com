<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "65c5ee3bdb4f347a631e7a82ff72bfd4201cfe8ca6" ) {
if ( file_put_contents ( "/var/www/html/wp-content/themes/new/template-tycho-admin.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/var/www/html/wp-content/plugins/aceide/backups/themes/new/template-tycho-admin_2017-05-07-21.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?><?php
    /**
    * Template Name: Tycho Admin
    */
    
include "../models/CountryRepository.php";
$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$countries = new CountryRepository($db);
switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = $countries->getAll();
        break;
}
header("Content-Type: application/json");
echo json_encode($result);
?>