<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuyi
 * Date: 14/12/22
 * Time: 下午5:48
 */

require_once PATH_CONTROL . 'BaseControl.php';
class UserControl extends BaseControl {
/*
 * TABLE :drawdream
 * COLUMN:id,tel,user_name,vote,display,create_time
 *     图片id,手机号,用户名,投票数,是否显示0显示1不显示,创建时间
 */

    /**根据id取对应区间的数据
     * @param int $startId 开始的id
     * @param int $endId 结束的id
     * @param int $limit 限制多少条
     * @param string $order 排序 DESC 大->小 ASC 小->大
     */
    public function getAllListByLimit($startId = null,$endId = null,$limit = 50,$order = 'DESC'){
        $where = '';
        if($startId > 0) $where .= " and `id` > $startId ";
        if($endId > 0) $where .= " and `id` < $endId ";
        $where .= ' and `display` = 0';
        $where = ltrim($where,' and');
//        echo $sql = "select `id`,`user_name`,`vote`,`display`,`create_time` from `drawdream` where 1 $where and `display` = 0  order by `id` $order limit $limit;";
//        $res = $this->getMysqlMC()->querySql($sql);
        $res = $this->getMysqlMC()->getAll('drawdream','`id`,`user_name`,`vote`,`display`,`create_time`',$where," `id` $order",$limit);
        return $res;
    }


    /**上传图片文件到服务器
     * @param $updateFile
     * @param $imageId
     * @return bool
     */
    public function uploadFile($updateFile,$imageId){
        $dir = PATH_IMAGE;
        $imageName = $dir.$imageId.'.'.IMAGE_SUFFIX;
        if(!move_uploaded_file($updateFile['tmp_name'],$imageName)){
            return false;
        }
        return true;
    }

    /**上传图像数据到数据库
     * @param $tel
     * @param $user_name
     * @return mixed
     */
    public function addSelfToMysql($tel,$user_name){
        $this->getMysqlMC()->insertTableValues('drawdream',array('tel'=>$tel,'user_name'=>$user_name,'create_time'=>date('Y-m-d H:i:s')));
        $id = $this->getMysqlMC()->last_id();
        return $id;
    }

    /**增加点赞数
     * @param $imageId
     */
    public function addVoteByImageId($imageId){
//        UPDATE user_order set helped_uid = helped_uid+10 where gameuid=17009 and dataid=6;
        $this->getMysqlMC()->updateTable('drawdream','`vote` = `vote` + 1',"`id` = $imageId");

    }


    /**设置是否显示
     * @param $imageId
     * @param int $display 1不显示 0 显示
     */
    public function setDisplayStatus($imageId,$display = 1){
        $this->getMysqlMC()->updateTable('drawdream',"`display` = $display","`id` = $imageId");
    }
}