<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2014/12/23
 * Time: 9:54
 */
require_once PATH_CONTROL.'BaseControl.php';
class ViewControl extends BaseControl{



    public function showPage($pageName){
        return require_once PATH_VIEW."$pageName.php";
    }

}