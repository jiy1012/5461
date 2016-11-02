<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuyi
 * Date: 14/12/22
 * Time: 下午5:56
 */
require_once PATH_MODEL . 'Mysql.class.php';

class BaseControl {

    private $mysqlMC = null;

    protected function getMysqlMC(){
        if($this->mysqlMC == null){
            $this->mysqlMC = new Mysql(array(MYSQL_HOST,MYSQL_PORT,MYSQL_USER,MYSQL_PASS,MYSQL_DBNAME),true);
        }
        return $this->mysqlMC;
    }





}