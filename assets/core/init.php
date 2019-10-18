<?php
// Start Session
if (!isset($_SESSION)) {
  session_start();
}

// Create and initialize variables
$errors = array();

// Define paths
define("DS", DIRECTORY_SEPARATOR);
define("ROOT_DIRECTORY", dirname(dirname(dirname(__FILE__))).DS);

// Require resources
require_once ROOT_DIRECTORY . "assets/core/db/connect.php";
require_once ROOT_DIRECTORY . "assets/core/load_classes.php";
require_once ROOT_DIRECTORY . "assets/core/functions.php";

//var_dump(hash('sha1', 'expert')); die();

//dd($_SESSION);
// Create instance/object of classes
$user = new User();

$profile = new Profile();

// $state = new States();
// $lga = new Lga();

$session = new Session();
$post = new Post();
$comments = new Comment();

$paginate = new Paginate();

// Image variables
$document = new Document();
$photo = new Photograph();

// Fetch page url
$page = basename($_SERVER['PHP_SELF']);
