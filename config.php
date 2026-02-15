<?php
// Common settings
$pageDir = 'pages'; // Folder path to store page files
$pageExtention = '.html'; // File extension
$list_excerpt_length = 100;

// Database configuration
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'jobsearch'); 

// Start session
if(!session_id()){
   session_start();
}