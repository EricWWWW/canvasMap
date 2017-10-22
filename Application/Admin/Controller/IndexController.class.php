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

        $this->assign('user_name',session('user_name'));

        $this->show();
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
            $upload->maxSize   =     5242880 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './map'; // 设置附件上传根目录
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
                        'city_id' => $city_id,
                        'url' => C('IMG_ROOT').$i[savepath] . $i[savename],
                        'create_time' => date("Y-m-d"),
                    );
                   M('img')->add($arr);
               }

                $res['status'] = 1;
               $res['msg'] = '上传成功';
            }
         }

        $this->ajaxReturn($res);


    }
}