<?php
namespace Admin\Controller;
use MRBS\Exception;
use Think\Controller;
class IndexController extends Controller {
  /*
   * session不存在时，跳转到登录页
   */
    public function index(){

        if(!session('user_name')){
            redirect(U('Index/login'));
        }

        $count = M('img')->count();
        $page  = new \Think\Page($count,30);
        $page->setConfig('theme','%UP_PAGE%%FIRST%%LINK_PAGE%%DOWN_PAGE%');
        $show = $page->show();

        $data = M()
            ->table('map_img as a')
            ->join('map_city as b on a.city_id = b.city_id')
            ->join('map_province as c on b.province_id = c.province_id')
            ->order('a.create_time desc,c.province_zh desc')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        $page->setConfig('theme','%UP_PAGE%');

            //        $img = M()
//            ->table('map_city as a')
//            ->join('map_img as b on a.city_id = b.city_id')
//            ->where(array('a.city_name' => $city))
//            ->order('b.create_time desc')
//            ->page(1,10)
//            ->select();
//
//        $this->assign('img',$img);

        $this->assign('data',$data);
        $this->assign('page',$show);
        $this->assign('user_name',session('user_name'));

        $this->show();
        dump($data);
    }

    /*
     *  登录页，处理登陆逻辑
     */

    public function login(){
        if(IS_POST){
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            if(M('user')->where(array('user_name' => $user_name,'user_password' => md5($user_password)))->find()){
               session('user_name',$user_name);
               redirect(U('Index/index'));
            }
            else{
               $this->error('账号错误');
            }
        }

        $this->show();
    }

    /*
     * 上传图片，逻辑处理
     */

    public function uploadImg(){
        $province = I('province');
        $city = I('city');

        if(!$province || !$city){
            $res['status'] = 0;
            $res['msg'] = '请完善您的信息';
        }
        else{

            $province_id = M('province')->where(array('province_zh' => $province))->getField('province_id');
            M('province')->where(array('province_zh' => $province))->setField('is_visited',1);
            $city_id = M('city')->where(array('province_id' => $province_id,'city_name' => $city))->getField('city_id');

            $upload = new \Think\Upload();// 实例化上传类
            $upload->autoSub   =     false;//不使用子目录保存
            $upload->maxSize   =     20971520 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','webp');// 设置附件上传类型
            $upload->rootPath  =     '/map'; // 设置附件上传根目录
            $upload->savePath  =     $province.'/'.$city.'/'; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $res['status'] = 0;
                $res['msg'] = $upload->getError();
            }else{// 上传成功
               if(!$city_id){
                    $city_id = M('city')->add(array('province_id' => $province_id,'city_name' => $city));
                }
               foreach($info as $i){
                    $arr = array(
                        'city_id'        => $city_id,
                        'url'            => C('IMG_ROOT').$i[savepath] . $i[savename],
                        'create_time'    => date("Y-m-d"),
                        'location'       => I('location'),
                        'description'    => I('description'),
                        'path'           => $upload->rootPath .'/'. $i[savepath] . $i[savename],
                    );
                   M('img')->add($arr);
               }

                $res['status'] = 1;
               $res['msg'] = '上传成功';
            }
         }

        $this->ajaxReturn($res);


    }


    /*
     * 删除又拍云图片
     */
    public function deleteImg($id){


        $config = C('UPLOAD_TYPE_CONFIG');

        $upyun = new \Think\Upload\Driver\Upyun($config);
        $path = M('img')->where(array('id' => $id))->getField('path');
        $a = '/map/浙江省/杭州市/59f7ff7b3876e.png';

        $res = $upyun->remove($path);
        $res1 = M('img')->where(array('id' => $id))->delete();
        if($res && $res1){
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除成功'));
        }
        else{
           $this->ajaxReturn(array('status'=>0,'msg'=>'删除文件情况：'.$res.'，删除记录情况：'.$res1));
        }

    }
}