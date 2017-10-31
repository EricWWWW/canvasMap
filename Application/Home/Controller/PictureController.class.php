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
            $location = "{$city}";
        }
        else{
            $location = "{$province}  {$city}";
        }

//        $img = M()
//            ->table('map_city as a')
//            ->join('map_img as b on a.city_id = b.city_id')
//            ->where(array('a.city_name' => $city))
//            ->order('b.create_time desc')
//            ->page(1,10)
//            ->select();
//
//        $this->assign('img',$img);

        $this->assign('location',$location);
        $this->assign('city',$city);
        $this->display();
    }
    public function getImage($city,$page){
        $img = M()
            ->table('map_city as a')
            ->join('map_img as b on a.city_id = b.city_id')
            ->where(array('a.city_name' => $city))
            ->order('b.create_time desc')
            ->page($page,20)
            ->select();

        $this->ajaxReturn($img);
    }
}