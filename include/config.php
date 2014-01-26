<?php
$arConfig['database'] = array(
    'user' => 'root',
    'password' => '',
    'name' => 'snippets',
    'charset' => 'utf8'
);


date_default_timezone_set('Europe/Moscow');

@session_start();
if (isset($_POST['password'])) {
    $_SESSION['password'] = $_POST['password'];
}
if ($_SESSION['password'] != 'wotan') {
    ?>
    <form method="POST">
        <input type="password" name="password" value="" /> <input type="Submit" value=">>" />
    </form>
    <?php
    die();
}

//end of file 'config.php'
