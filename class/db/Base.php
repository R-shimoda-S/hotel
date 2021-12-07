<?php

/**
 * データベース基礎クラス
 */
class Base
{
    const DB_NAME = 'hotel';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    protected $dbh;

    public function __construct()
        {
            $dsn ='mysql:dbname='.self::DB_NAME.';host'.self::DB_HOST.';chareset=utf-8';
            $this->dbh = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
            // エラーが起きたときのモードを指定する
            // 「PDO::ERRMODE_EXCEPTION」を指定すると、エラー発生時に例外がスローされる
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        }
}
