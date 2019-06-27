<!DOCTYPE html>

<html lang="zh-Hant-TW">

<head>
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>bootstrap.min.css">
    <meta charset="utf-8" />
    <title>LineBot管理系統</title>
</head>

<body>

    <header>
        <nav class="navbar bg-info">
            <a class="d-flex navbar-brand text-light justify-content-center" href="#">
                <i class="h3 fas fa-robot mx-3"></i>
                LineBot管理系統
            </a>
        </nav>
    </header>

    <main class="container">
        <div class="row justify-content-center" style="height: 85vh">
            <div class="col-4 text-center bg-light">
                <div class="media text-left">
                    <div class="h3">
                        <i class="fa fa-user mr-3"></i>
                    </div>
                    <div class="media-body align-self-center">
                        <div class="h5">User</div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
            </div>
            <div class="col-8 text-left h-100">
                <form class="d-flex flex-column form-signin h-100" action="index.php?p=admin&c=Manager&a=index" method="POST">
                    <div class="d-flex form-group">
                        <label class="form-label sr-only" for="to">發送給</label>
                        <input class="h5 form-control-plaintext" type="text" readonly id="to" name="to" value="全體推送">
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="alert alert-warning p-1 <?php if (!isset($_POST['text']) || $_POST['text'] != '')  echo 'd-none'; ?>" role="alert">
                        請輸入要發送的內容
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="mb-auto"></div>
                    <div class="mb-3 roll" style="overflow:auto;">
                        <div class="d-flex flex-column-reverse align-items-end">
                            <?php foreach (self::$var['info'] as $v) : ?>
                                <div class="alert alert-success text-left" role="alert">
                                    <?php $text = "[抽股票]{$v['股票代號股票名稱']} 開始日期({$v['開始日期']})" . "<br/>"; ?>
                                    <?php $text .= "參考價格 {$v['參考價格']}元 申購價格 {$v['申購價格']}元" . "<br/>"; ?>
                                    <?php $text .= "抽中獲利 {$v['抽中獲利']}元 獲利率 {$v['獲利率']}"; ?>
                                    <?php echo "{$text}"; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-inline align-items-end">
                        <div class="form-group flex-grow-1">
                            <label for="push-text"></label>
                            <textarea class="form-control w-100" id="push-text" rows="2" name="text"></textarea>
                        </div>
                        <button class="btn btn-link align-self-center ml-3 pb-0" type="submin">
                            <i class="fas fa-paper-plane h1"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
        </div>
    </main>
    <script defer src="https://use.fontawesome.com/releases/v5.9.0/js/all.js" integrity="sha384-7Gk1S6elg570RSJJxILsRiq8o0CO99g1zjfOISrqjFUCjxHDn3TmaWoWOqt6eswF" crossorigin="anonymous"></script>
    <script src="<?php echo JS_DIR ?>jquery-3.3.1.slim.min.js"></script>
    <script src="<?php echo JS_DIR ?>popper.min.js"></script>
    <script src="<?php echo JS_DIR ?>bootstrap.min.js"> </script>
    <script>
        $(document).ready(function() {
            $("div.roll").scrollTop($("form.form-signin").height());
        });
    </script>
</body>

</html>