<?php
class Mysql extends SaeMysql {
	
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
			$sql.="and $condition";
		}
		if ($order!='') {
			$sql.="order by $order ";
		}
		if ($limit!='') {
			$sql.="limit $limit";
		}
		$data=$this->getData($sql);
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
		$data=$this->getLine($sql);
		return $data;
	}
	
	/**获取一个值
	 * @param string $table
	 * @param string $field
	 * @param string $condition
	 * @param string $order
	 * @return unknown_type
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
		$data=$this->getVar($sql);
		return $data;
	}
	
	/**插入数据库
	 * @param str $table
	 * @param arr $values 字段与值 为array的key和value
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
		$this->runSql($sql);
	}
	
	/**插入数据库
	 * @param str $table
	 * @param str $values
	 */
	public function insertValues($table,$values){
		$columns=$this->getData("SHOW COLUMNS FROM".$table);
		$columns_str="";
		foreach ($columns as $k =>$v){
			$columns_str.=$v['Field'].",";
		}
		$columns_str=substr($columns_str, 0,-1);
		$sql="insert into $table ($columns) values ($values)";
		$this->runSql($sql);
	}
	
	
	/**删除数据
	 * @param str $table
	 * @param str $condition
	 */
	public function deleteTable($table,$condition){
		$sql="delete from $table where $condition";
		$this->runSql($sql);
	}
	
	/**更新数据
	 * @param str $table
	 * @param str $fieldvalue
	 * @param str $condition
	 */
	public function updateTable($table,$fieldvalue,$condition){
		$sql="update $table set $fieldvalue where $condition";
		$this->runSql($sql);
	}
	
	
	/**更新或插入数据库
	 * @param str $table
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
		$this->runSql($sql);
	}
	
	/**同mysql_insert_id
	 * @return int
	 */
	public function lastId(){
		return parent::lastId;
	}
	
	/**运行sql语句
	 * @param str $sql
	 * @return unkown result
	 */
	public function runSql($sql){
		return parent::runSql($sql);
	}
	
	
}

?>