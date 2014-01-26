<?php

define('INC', getcwd() . '/include');

require INC . '/config.php';
require INC . '/xsql.class.php';
require INC . '/kernel.class.php';

header("Content-Type: application/json; charset=utf-8");

$CKernel = new CKernel($arConfig['database']);


if (isset($_REQUEST['action'])) {
    $sAction = $_REQUEST['action'];
} else {
    die();
}


$arJSON = array();

if ($sAction == 'search') {

    if (isset($_REQUEST['query'])) {
        $sQuery = $_REQUEST['query'];
    } else {
        die();
    }

    $arIds = array();
    $arItems = array();

    $arResults = $CKernel->getList(array('FindStr' => $sQuery), true);
    foreach ($arResults AS $arItem) {
        $arItems[] = $arItem['content'];
        $arIds[] = $arItem['id'];
    }

    $arJSON = array(
        'items' => $arItems,
        'ids' => $arIds,
    );
} elseif ($sAction == 'get') {
    if (isset($_REQUEST['id'])) {
        $iId = (int) $_REQUEST['id'];
    } else {
        die();
    }

    $arItem = $CKernel->getById($iId);
    if ($arItem) {
        $arJSON = array(
            'content' => $arItem['content']
        );
    }
} elseif ($sAction == 'save') {
    if (!isset($_REQUEST['content']) || !isset($_REQUEST['id'])) {
        die();
    }

    $sContent = (string) $_REQUEST['content'];
    $iId = (int) $_REQUEST['id'];

    $arItem = $CKernel->getById($iId);
    if ($arItem) {
        $CKernel->update($iId, $sContent);
        $arJSON = array(
            'content' => $sContent
        );
    }
}



echo json_encode($arJSON);