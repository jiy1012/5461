<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuyi
 * Date: 14/12/22
 * Time: 下午5:33
 */

class Mysql {

    private $host = null;
    private $port = null;
    private $accesskey = null;
    private $secretkey = null;
    private $appname =  null;
    private $do_replication= true;

    private $db_read = null;
    private $db_write = null;

    public function __construct( $db ,$do_replication)
    {
        $this->host = $db[0];
        $this->port = $db[1];
        $this->accesskey = $db[2];
        $this->secretkey = $db[3];
        $this->appname =  $db[4];
        $this->do_replication= $do_replication;

    }

    private function connect( $is_master = true )
    {

        if( !$db = mysql_connect( $this->host . ':' . $this->port , $this->accesskey , $this->secretkey ) )
        {
            die('can\'t connect to mysql ' . $this->host . ':' . $this->port );
        }

        mysql_select_db( $this->appname , $db );
        return $db;
    }

    private function db_any()
    {

    }

    private function db_read()
    {
        if( isset( $this->db_read ) )
        {
            mysql_ping( $this->db_read );
            return $this->db_read;
        }
        else
        {
            if( !$this->do_replication ) return $this->db_write();
            else
            {
                $this->db_read = $this->connect( false );
                return $this->db_read;
            }
        }
    }

    private function db_write()
    {
        if( isset( $this->db_write ) )
        {
            mysql_ping( $this->db_write );
            return $this->db_write;
        }
        else
        {
            $this->db_write = $this->connect( true );
            return $this->db_write;
        }
    }

    public function save_error()
    {
        $GLOBALS['LAST_ERROR'] = mysql_error();
        $GLOBALS['LAST_ERRNO'] = mysql_errno();
    }


    private  function run_sql( $sql )
    {
        $ret = mysql_query( $sql , $this->db_write() );
        $this->save_error();
        return $ret;
    }

    protected function get_data( $sql )
    {
        echo $GLOBALS['LAST_SQL'] = $sql;
        $data = Array();
        $i = 0;
        $result = mysql_query( $sql , $this->do_replication ? $this->db_read() : $this->db_write()  );

        $this->save_error();

        while( $Array = mysql_fetch_array($result, MYSQL_ASSOC ) )
        {
            $data[$i++] = $Array;
        }

        /*
        if( mysql_errno() != 0 )
            echo mysql_error() .' ' . $sql;
        */

        mysql_free_result($result);

        if( count( $data ) > 0 )
            return $data;
        else
            return false;
    }

    protected function get_line( $sql )
    {
        $data = $this->get_data( $sql );
        return @reset($data);
    }

    protected  function get_var( $sql )
    {
        $data = $this->get_line( $sql );
        return $data[ @reset(@array_keys( $data )) ];
    }

    public function last_id()
    {
        $result = mysql_query( "SELECT LAST_INSERT_ID()" , $this->db_write() );
        return reset( mysql_fetch_array( $result, MYSQL_ASSOC ) );
    }

    public function close_db()
    {
        if( isset( $this->db_read ) )
            @mysql_close( $this->db_read );

        if( isset( $this->db_write ) )
            @mysql_close( $this->db_write );

    }

    public function escape( $str )
    {
        if( isset($this->db_read)) $db = $this->db_read ;
        elseif( isset($this->db_write) )	$db = $this->write;
        else $db = $this->db_read();

        return mysql_real_escape_string( $str , $db );
    }

    public function errno()
    {
        return $GLOBALS['LAST_ERRNO'];
    }

    public function error()
    {
        return $GLOBALS['LAST_ERROR'];
    }


    /**获取所有数据
     * @param string $table
     * @param string $field
     * @param string $condition
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getAll($table,$field='',$condition='',$order='',$limit=''){
        if ($field=='') {
            $field='*';
        }
        $sql="select $field from $table where 1  ";
        if ($condition!='') {
            $sql.=" and $condition ";
        }
        if ($order!='') {
            $sql.=" order by $order ";
        }
        if ($limit!='') {
            $sql.=" limit $limit ";
        }
        $data=$this->get_data($sql);
        return $data;
    }

    /**获取一条数据
     * @param string $table
     * @param string $field
     * @param string $condition
     * @param string $order
     * @return array
     */
    public  function getRow($table,$field='',$condition='',$order=''){
        if ($field=='') {
            $field='*';
        }
        $sql="select $field from $table where 1 ";
        if ($condition!='') {
            $sql.="and $condition";
        }
        if ($order!='') {
            $sql.="order by $order ";
        }
        $data=$this->get_line($sql);
        return $data;
    }

    /**获取一个值
     * @param string $table
     * @param string $field
     * @param string $condition
     * @param string $order
     * @return array $data
     */
    public  function getOne($table,$field='',$condition='',$order=''){
        if ($field=='') {
            $field='*';
        }
        $sql="select $field from $table where 1 ";
        if ($condition!='') {
            $sql.="and $condition";
        }
        if ($order!='') {
            $sql.="order by $order ";
        }
        $data=$this->get_var($sql);
        return $data;
    }

    /**插入数据库
     * @param string $table
     * @param array $fieldsvalues 字段与值 为array的key和value
     */
    public function insertTableValues($table,$fieldsvalues){
        $columns="";
        $value="";
        foreach ($fieldsvalues as $k=>$v){
            $columns.=$k.",";
            $value.="'".$v."',";
        }
        $columns=substr($columns, 0,-1);
        $value = substr($value, 0,-1);
        $sql="insert into $table ($columns) values ($value)";
        $this->run_sql($sql);
    }

    /**插入数据库
     * @param string $table
     * @param string $values
     */
    public function insertValues($table,$values){
        $columns=$this->get_data("SHOW COLUMNS FROM ".$table);
        $columns_str="";
        foreach ($columns as $k =>$v){
            $columns_str.=$v['Field'].",";
        }
        $columns_str=substr($columns_str, 0,-1);
        $sql="insert into $table ($columns_str) values ($values)";
        $this->run_sql($sql);
    }


    /**删除数据
     * @param string $table
     * @param string $condition
     */
    public function deleteTable($table,$condition){
        $sql="delete from $table where $condition";
        $this->run_sql($sql);
    }

    /**更新数据
     * @param string $table
     * @param string $fieldvalue
     * @param string $condition
     */
    public function updateTable($table,$fieldvalue,$condition){
        $sql="update $table set $fieldvalue where $condition";
        $this->run_sql($sql);
    }

    /**更新数据
     * @param string $table
     * @param array $fieldvalue
     * @param array $condition
     */
    public function updateTableValue($table,$fieldvalue,$condition){
        $fieldvalue_arr=array();
        foreach($fieldvalue as $field=>$value){
            $fieldvalue_arr[]= $field.'="'.$value.'"';
        }
        $fieldvalue_str=implode(',',$fieldvalue_arr);
        $condition_arr=array();
        foreach($condition as $k=>$v){
            $condition_arr[]=$k.'="'.$v.'"';
        }
        $condition_str=implode(',',$condition_arr);
        echo $sql="update $table set $fieldvalue_str where $condition_str";
        $this->run_sql($sql);
    }

    /**更新或插入数据库
     * @param string $table
     * @param array $fieldvalue 字段与值 为array的key和value
     */
    public function replaceTable($table,$fieldvalue){
        $columns="";
        $value="";
        foreach ($fieldvalue as $k=>$v){
            $columns.=$k.",";
            $value.="'".$v."',";
        }
        $columns=substr($columns, 0,-1);
        $value = substr($value, 0,-1);
        $sql="replace into $table ($columns) values ($value)";
        $this->run_sql($sql);
    }


    /**执行sql语句
     * @param $sql
     * @return resource
     */
    public function querySql($sql){
        return $this->run_sql($sql);
    }






}

?>