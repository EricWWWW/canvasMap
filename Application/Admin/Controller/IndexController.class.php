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


        function upload_file($file_info, $arr_type=array('image/jpeg','image/png','image/gif','image/jpg'), $file_allow_size=31457280, $path='./Uploads/'){

            // 获取原始文件名
            $file_name = $file_info['name'];
            //1. 判断文件是否上传成功
            //接收文件上传的错误代码
            $error_code = $file_info['error'];
            if ($error_code != 0) {
                $result['status'] = 0;
                $result['msg'] = '文件'.$file_name.'上传失败，错误码：'.$error_code;
                return $result;
            }
            //2 判断上传文件的类型是否合法
            //获取上传文件的类型
            $file_type = $file_info['type'];
            if (!in_array($file_type, $arr_type)) {
                $result['status'] = 0;
                $result['msg'] = '文件'.$file_name.'类型不合法';
                return $result;
            }

            //3. 判断文件上传文件的大小是否合法
            //获取上传文件的大小
            $file_size = $file_info['size'];
            if ($file_size > $file_allow_size) {
                $result['status'] = 0;
                $result['msg'] = '文件'.$file_name.'大小超出允许的的值'.($file_allow_size/1000000).'M';
                return $result;
            }

            //4.将文件移动到指定位置
            //获取上传文件的临时文件名
            $tmp_name = $file_info['tmp_name'];

            //获取原始文件的后缀名
            $tmp_arr = explode('.', $file_name);
            $extension_name = array_pop($tmp_arr);

            //处理文件上传路径
            $path = rtrim($path, '/').'/';

            //生成新的文件名,
            do {
                $new_file_name = md5($tmp_name.time()).'.'.$extension_name;
            } while (file_exists($path.$new_file_name));

            //上传文件
            $bool = move_uploaded_file($tmp_name, $path.$new_file_name);

            // 判断文件是否上传成功
            if ($bool) {
                $result['status'] = 1;
                $result['msg'] = '文件'.$file_name .'上传成功';
                return $result;
            } else {
                $result['status'] = 0;
                $result['msg'] = '文件'.$file_name.'上传失败';
                return $result;
            }


        }

        //1. 接收多文件上传信息
        $upload_file_info = $_FILES['file'];

        //2. 重组上传数字信息
        foreach ($upload_file_info['name'] as $key => $value) {
            $files[$key]['name'] = $value;
            $files[$key]['type'] = $upload_file_info['type'][$key];
            $files[$key]['tmp_name'] = $upload_file_info['tmp_name'][$key];
            $files[$key]['error'] = $upload_file_info['error'][$key];
            $files[$key]['size'] = $upload_file_info['size'][$key];
        }

        //3. 上传文件
        foreach ($files as $key => $value) {
            $res[$key] = upload_file($value);
        }

        $this->ajaxReturn($res);


    }
}