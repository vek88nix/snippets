<?php
define('INC', getcwd() . '/include');

require INC . '/config.php';
require INC . '/xsql.class.php';
require INC . '/kernel.class.php';

header("Content-Type: text/html; charset=utf-8");

$CKernel = new CKernel($arConfig['database']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gungnir snippets</title>
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <meta name="charset" content="utf-8" />
        <style type="text/css">
            .typeahead {
                width: 100%;
            }
            li {
                overflow: hidden;
            }
            strong {
                color: red;
            }
            #main-menu {
                position: static;
                top: 0px;
                left: 0px;
                width: 1170px;
                border-radius: 4px;
                float: left;
                min-width: 160px;
                padding: 5px 0px;
                margin: 2px 0px 0px;
                list-style: none outside none;
                background-color: rgb(255, 255, 255);
                border: 1px solid rgba(0, 0, 0, 0.2);
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
                background-clip: padding-box; display: block
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br />
            <div class="span8">
                <input type="text" placeholder="Search..." autocomplete="off" id="keyword" value="" style="width: 100%;" />
            </div>
            <div class="span3">
                <input onclick="window.location = 'add.php';" type="submit" style="width: 100%; height: 29px;" class="btn btn-inverse" value="New snippet" />
            </div>
            <br style='clear: both' />
            <pre id="content" style="display: none"></pre>

            <ul class="dropdown-menu typeahead" id="main-menu">
                <?php
                $arItems = $CKernel->GetList(false, true);

                foreach ($arItems AS $arItem) {
                    ?>
                    <li>
                        <a href="javascript:void(0);" data-id="<?= $arItem['id']; ?>">
                            <?= htmlspecialchars($arItem['content']); ?>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <script src="js/common.js"></script>
    </body>
</html>