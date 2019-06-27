<!DOCTYPE html>

<html lang="zh-Hant-TW">

<head>
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>bootstrap.min.css">
    <meta charset="utf-8" />
    <title>LineBot管理系統</title>
</head>

<body>
    <div class="container my-5 py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-4 text-center">
                <form class="form-signin" action="/index.php?p=admin&c=Admin&a=check" method="POST">
                    <img class="mb-4" src="<?php echo ICON_DIR ?>/icon.png" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">LineBot管理系統</h1>
                    <label for="inputUsername" class="sr-only">Username</label>
                    <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="user" required>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" required>
                    <button class="btn btn-sm btn-primary btn-block my-3 w-25" type="submit">登入</button>
                    <p class="my-5 text-muted">&copy; 2019-2019</p>
                </form>
            </div>
        </div>
    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.9.0/js/all.js" integrity="sha384-7Gk1S6elg570RSJJxILsRiq8o0CO99g1zjfOISrqjFUCjxHDn3TmaWoWOqt6eswF" crossorigin="anonymous"></script>
    <script src="<?php echo JS_DIR ?>jquery-3.3.1.slim.min.js"> </script>
    <script src="<?php echo JS_DIR ?>popper.min.js"> </script>
    <script src="<?php echo JS_DIR ?>bootstrap.min.js"> </script>
</body>

</html>