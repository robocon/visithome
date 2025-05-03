<?php 
include_once 'config.php';

$action = sprintf('%s', $_POST['action'] ?? '');
if($action==='login'){
    echo checkLogin($_POST['username'], $_POST['password']);
    exit;

}elseif ($action==='logout') {
    echo doLogout();
    exit;
    
}

