<?php
define('INC', getcwd() . '/include');

require INC . '/config.php';
require INC . '/xsql.class.php';
require INC . '/kernel.class.php';

header("Content-Type: text/html; charset=utf-8");

$CKernel = new CKernel($arConfig['database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content']) && $CKernel->add($_POST['content'])) {
    header("Location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>New snippet</title>
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <meta name="charset" content="utf-8" />
        <style type="text/css">
            * {
                font-family: Courier-New;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br />
            <div class="span10" style='text-align: center;'>
                <form method='POST'>
                    <textarea style='width: 100%; height: 400px;' name='content'></textarea>
                    <input type="submit" style="width: 100%; height: 29px;" class="btn btn-inverse" value="Добавить" />
                </form>
            </div>


        </div>

    </body>
</html>