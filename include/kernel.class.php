<?php

if (!defined('INC'))
    die('Access denied!');

class CKernel extends CxSQL {

    public function __construct($arDatabaseConfig) {
        parent::__construct($arDatabaseConfig);
    }

    public function getList($arFilter = array(), $bLine = false, $arSort = false) {
        if (isset($arFilter['FindStr'])) {
            $sFindStr = $arFilter['FindStr'];
        } else {
            $sFindStr = false;
        }

        $sWhere = "";
        if ($sFindStr) {
            $sFindStr = $this->filter($sFindStr);

            $sWhere .= " AND `content` LIKE '%{$sFindStr}%'";
        }

        if (isset($arFilter['FindId'])) {
            $arFindId = (array) $arFilter['FindId'];
            $arFindId = @array_map(function($value) {
                                return (int) $value;
                            }, $arFindId);
            $sWhere = " AND `id` IN (" . implode(", ", $arFindId) . ")";
        } else {
            $arFindId = false;
        }

        if ($arSort) {
            $arColumns = $this->aread("SHOW COLUMNS FROM `snippets`");
            foreach ($arColumns AS &$item) {
                $item = $item['Field'];
            }
            unset($item);

            if (!in_array($arSort[0], $arColumns) || !in_array(strtoupper($arSort[1]), array('DESC', 'ASC'))) {
                $arSort = false;
            }
        }

        if (!$arSort) {
            $arSort = array('id', 'DESC');
        }

        $query = "SELECT * "
                . "FROM `snippets` "
                . "WHERE 1=1 {$sWhere} "
                . "ORDER BY `{$arSort[0]}` {$arSort[1]}";

        $arResults = $this->aread($query);
        if ($sFindStr && $bLine) {
            foreach ($arResults AS &$arItem) {
                $sContent = $arItem['content'];

                $iStrPos = strpos($sContent, $sFindStr);
                $iBegin = $iEnd = $iStrPos;
                while (substr($sContent, $iBegin, 1) != "\n" && $iBegin != 0) {
                    $iBegin--;
                }

                while (substr($sContent, $iEnd, 1) != "\n" && $iEnd != strlen($sContent)) {
                    $iEnd++;
                }

                $sLine = substr($sContent, $iBegin, $iEnd - $iBegin - 1);

                $arItem['content'] = trim($sLine);
            }
            unset($arItem);
        } elseif ($bLine) {
            foreach ($arResults AS &$arItem) {
                if ($iStrPos = strpos($arItem['content'], "\n")) {
                    $arItem['content'] = trim(substr($arItem['content'], 0, $iStrPos + 1));
                }
            }
            unset($arItem);
        }

        return $arResults;
    }

    public function getById($iId, $bLine = false) {
        $arResults = $this->getList(array('FindId' => (int) $iId), $bLine);
        return count($arResults) ? $arResults[0] : false;
    }

    public function add($sContent, $iUserId = 1) {
        $iDate = time();
        $sContent = $this->filter((string) $sContent);
        $iUserId = (int) $iUserId;


        $sContent = trim($sContent);

        $this->query("INSERT INTO `snippets` (`date`, `content`, `user_id`) VALUES(

                {$iDate}, '{$sContent}', {$iUserId})");
        return $this->insertId();
    }

    public function update($iId, $sContent) {
        $iId = (int) $iId;
        $sContent = $this->filter((string) $sContent);

        return (bool) $this->query("UPDATE `snippets` SET `content`='{$sContent}' WHERE `id`={$iId}");
    }

}

//end of file 'kernel.class.php'