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
            <div class="col-lg-4 col-md-8 text-center">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 font-weight-normal">LineBot管理系統</h1>
                    </div>
                    <div class="card-body mb-5 pt-0">
                        <img class="mb-3" src="<?php echo ICON_DIR ?>/icon.png" alt="" width="72" height="72">
                        <form class="form-login" action="/index.php?p=admin&c=Admin&a=check" method="POST">
                            <div class="form-group">
                                <label for="inputUsername" class="sr-only">Username</label>
                                <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="user" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" required>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit">登入</button>
                        </form>
                    </div>
                    <p class="text-muted small">&copy; 2019-2019</p>
                </div>
            </div>
        </div>
    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.9.0/js/all.js" integrity="sha384-7Gk1S6elg570RSJJxILsRiq8o0CO99g1zjfOISrqjFUCjxHDn3TmaWoWOqt6eswF" crossorigin="anonymous"></script>
    <script src="<?php echo JS_DIR ?>jquery-3.3.1.slim.min.js"> </script>
    <script src="<?php echo JS_DIR ?>popper.min.js"> </script>
    <script src="<?php echo JS_DIR ?>bootstrap.min.js"> </script>
</body>

</html>