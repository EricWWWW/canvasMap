<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $bingURL = "./Public/static/img/bingImg/".rand(1,8).".jpg";
        $this->assign('bingURL',$bingURL);
        $this->display();
    }
}