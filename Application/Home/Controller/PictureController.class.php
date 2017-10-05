<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2017/8/30
 * Time: 10:36
 */
namespace Home\Controller;
use Think\Controller;
class PictureController extends Controller {
    public function index(){
        $province = I('province');
        $city = I('city');
        if(!$province || !$city){
            redirect(U('Index/index'));
        }

        if($province == '上海' || $province == '北京' || $province == '天津' || $province == '重庆'){
            $location = " 我在 {$city}市~";
        }
        else{
            $location = " 我在 {$province}省 {$city}市~";
        }

        $this->assign('location',$location);
        $this->assign('city',$city);
        $this->display();
    }
}