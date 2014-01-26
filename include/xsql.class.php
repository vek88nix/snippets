<?php

class CxSQL {

    private $arConfig = array();
    private $rDBLink;
    private $rSQL;
    private $sLastQuery;

    public function __construct($arConfig) {
        $this->arConfig = $arConfig;
        $this->connect();
    }

    private function connect() {
        $this->rDBLink = @mysql_pconnect($this->arConfig['host'], $this->arConfig['user'], $this->arConfig['password']);

        if (!$this->rDBLink) {

            $this->error('Can\'t connect to database');
        }

        $msd = @mysql_select_db($this->arConfig['name'], $this->rDBLink);

        if (!$msd) {
            $this->error('Can\'t select database');
        }

        $this->query("SET names " . $this->arConfig['charset']);
        $this->query("SET character_set_client = " . $this->arConfig['charset']);
        $this->query("SET character_set_connection = " . $this->arConfig['charset']);
        $this->query("SET character_set_results = " . $this->arConfig['charset']);
        $this->query("SET SQL_BIG_SELECTS = 1");
    }

    public function escape($str) {
        return @mysql_real_escape_string($str, $this->rDBLink);
    }

    public function filter($str) {
        return $this->escape($str);
    }

    public function query($q) {
        $this->lq = $q;

        $sql = @mysql_query($q, $this->rDBLink);
        if (!$sql) {
            $this->error(mysql_error($this->rDBLink));
        }
        return $this->sql = $sql;
    }

    public function count() {
        return @mysql_num_rows($this->sql);
    }

    public function read($q = false, $var = false) {

        if ($q !== false && $this->lq !== $q) {
            $this->query($q);
        }

        $ret = @mysql_fetch_assoc($this->sql);

        if ($var)
            return $ret[$var];

        return $ret;
    }

    public function aread($q, $var = false) {
        $arr = array();
        while ($i = $this->read($q, $var)) {
            $arr[] = $i;
        }
        return $arr;
    }

    public function insert_id() {
        return @mysql_insert_id($this->rDBLink);
    }

    public function insertId() {
        return $this->insert_id($this->rDBLink);
    }

    private function error($msg) {
        die("Query: " . $this->lq . "<br />\nError: " . $msg);
    }

}

