<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        /*
         * py爬的脚本 每次访问背景图片不同
         */
        $bingURL = "./Public/static/img/bingImg/".rand(1,8).".jpg";

        /*
         * 读取城市数据，曾经去过的，将数据加到数组里，返回前台
         */
        $data = M()
            ->table('map_province')
            ->select();

        for ($i = 0;$i<count($data);$i++){
            if($data[$i]["is_visited"]==1){
                $data[$i]['visited_city'] = M('city')->where(array('province_id' => $data[$i]['province_id']))->select();

            };
        }
        //dump($data);
        $this->assign('bingURL',$bingURL);
        $this->assign('data',$data);
        $this->display();
    }
}