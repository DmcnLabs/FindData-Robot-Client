<?php
namespace app\admin\controller;

use app\common\controller\Bbase;
use think\Session;
use app\admin\model\Users;

class Login extends Bbase
{

    protected function _initialize()
    {
        parent::_initialize();
    }

    //登录
    public function doLogin()
    {
        if(request()->isPost()){
            $postdata = input();
            $password = passwordencrypt($postdata['password']);
            //dump($password);die;
            $username = $postdata['username'];
            if(empty($username) || empty($postdata['password'])){
                $this->error('Account or password cannot be empty!');
            }
            $captcha = $postdata['seccode'];
            if(!captcha_check($captcha)){
                $this->error('Verification code error!');
            }

            $password = passwordencrypt($postdata['password']);

            $data['username'] = $username;
            $data['password'] = $password;
            $users = new Users();

            $res = $users->getInfo($data);
            if(empty($res)){

                $this->error('Wrong account or password!');
            }

            if($res){
                $users_model = new Users();
                $res['last_login_time'] = time();
                $users_model->setUserValue(array('uid'=>$res['uid']),'last_login_time',$res['last_login_time']);
                $res['usertype'] = $users_model->getUserGroup($res['user_type']);

                Session::set('uid',$res['uid']);
                Session::set('username',$res['username']);
                Session::set('usertype',$res['usertype']);
                unset($res['password']);
                Session::set('userinfo',$res);
                $this->success('Login successful','index/index');

            }
        }
        if(Session::get('uid') && Session::get('userinfo') && Session::get('username')){
            $this->redirect(url('index/index'));
        }
        return $this->fetch('dologin');
    }


    //注册
    public function loginOut()
    {
        Session::delete('uid');
        Session::delete('username');
        Session::delete('userinfo');
        Session::delete('usertype');
        $this->redirect('dologin');
    }

    public function register(){
        return $this->fetch('login/register');
    }

}
