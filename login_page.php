<?php 
include_once 'config.php';
if(!empty($_COOKIE['user'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/sweetalert2@11.js"></script>
</head>
<body>
    <h1>this is login page</h1>
    <div>
        <a href="javascript:void(0);" onclick="onClickLogin()">Login</a>
    </div>
    <div>
        <a href="register.php">Register</a>
    </div>
    <script>
        function onClickLogin() {
            const user = 'test';
            const pass = '1234';
            doLogin(user, pass);
        }

        async function doLogin(user,pass) {
            let formData = new FormData();
            formData.append('username', user);
            formData.append('password', pass);
            formData.append('action', 'login');
            await sendPost('login.php',formData).then((res)=>{
                if(res.status===200){
                    // notifySuccess(res.message);
                    window.location.href = 'index.php';
                }else{
                    notifyAlert(res.message);
                }
            });
        }

        async function sendPost(url, formData){
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            return data;
        }

        function notifyAlert(txt){
            Swal.fire({
                icon: 'error',
                title: 'อุ๊ปส์...',
                text: txt,
                allowOutsideClick: false
            });
        }

        function notifySuccess(txt){
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: txt
            });
        }
    </script>
</body>
</html>