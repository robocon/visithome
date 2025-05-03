<?php

function isLogin(){
    if(empty($_COOKIE['user'])){
        return false;
    }
}

function onLogin(){
    $cookie_name = "user";
    $cookie_value = "John Doe";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function checkLogin($username, $password){
    global $dbi;

    $sql = sprintf("SELECT `id`,`password` FROM `user` WHERE `username` = '%s' LIMIT 1", $dbi->real_escape_string($username));
    try{
        $q = $dbi->query($sql);
    } catch (Exception $e) {
        $res = ['status'=>400, 'message'=>$e->getMessage()];
    }
    if($q->num_rows == 0){
        $res = ['status'=>400, 'message'=>'ชื่อผู้ใช้ผิดพลาดกรุณาติดต่อผู้ดูแลระบบ'];

    }else{
        $user = $q->fetch_assoc();
        $passwordHash = $user['password'];

        if(password_verify($password, $passwordHash)){
            $res = ['status'=>200, 'message'=>'Login successful'];
            setcookie('user', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
        }else{
            $res = ['status'=>400, 'message'=>'ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบชื่อผู้ใช้และรหัสผ่าน'];
        }
    }
    echo json_encode($res);
    exit;
}

function doLogout(){
    
    $_SESSION = array();

    session_destroy();
    setcookie('user', '', -1, '/'); 
    echo json_encode(['status'=>200, 'message'=>'Logout successful']);
    exit;
}