<!DOCTYPE html>

<html lang="zh-Hant-TW">

<head>
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>bootstrap.min.css">
    <meta charset="utf-8" />
    <title>LineBot管理系統</title>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-4 text-center">
            </div>
            <div class="col-4 text-center">
                <form class="form-signin" action="/index.php?p=push&c=Push&a=managerPush" method="POST">
                    <div class="form-group">
                        <label for="to">發送給</label>
                        <select class="form-control" id="to" name="to">
                            <option value="all">所有人</option>
                        </select>
                    </div>


                    <div class="row  px-4" style="height:250px">
                        <?php if ($_GET['extra']) : ?>
                            <div class="col align-self-end">
                                <div class="row justify-content-end">
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $_GET['extra'] ?>
                                    </div>

                                </div>
                                <div class="row justify-content-end"><small>已傳送</small></div>
                            <?php else : ?>
                                <div class="col">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <?php echo '請輸入要發送的內容' ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="push-text"></label>
                            <textarea class="form-control" id="push-text" rows="2" name="text"></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary btn-block my-3 w-25" type="submit">發送</button>
                </form>
                <script src="<?php echo JS_DIR ?>bootstrap.min.js"> </script>
            </div>
            <div class="col-4 text-center">
            </div>
        </div>
    </div>
</body>

</html>