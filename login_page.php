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
    <title>😱</title>
    <link href="bootstrap-5.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="js/sweetalert2@11.js"></script>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <style>
        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }
        .m-auto {
            margin: auto !important;
        }
        .w-100 {
            width: 100% !important;
        }
    </style>
    <main class="form-signin w-100 m-auto">
        <form onsubmit="onSubmitLogin()" class="form-signin w-100 m-auto">
            <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <div>😱</div>
            <h1 class="h3 mb-3 fw-normal">เว็บเอ๊ะๆ</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="inputUsername" placeholder="Username">
                <label for="inputUsername">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                <label for="inputPassword">Password</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="checkDefault">
                <label class="form-check-label" for="checkDefault">จดจำ</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">เข้าสู่ระบบ</button>
            <!-- <p class="mt-5 mb-3 text-body-secondary">© 2017–2025</p> -->
        </form>
    </main>
    <script>
        function onSubmitLogin() {
            event.preventDefault();
            const user = document.getElementById('inputUsername').value;
            const pass = document.getElementById('inputPassword').value;
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