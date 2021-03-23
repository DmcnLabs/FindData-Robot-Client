<?php
namespace app\admin\controller;
use think\Session;

use app\admin\model\Users as modelUsers;
use app\admin\model\AuthGroupAccess;


class User extends Base
{
    public $modelUser = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->modelUsers = new modelUsers();
    }

    public function index()
    {
        $title = 'User list';
        $perpage    = config('pagesize');
        $page       = empty(input('get.page')) ? 1 : intval(input('get.page'));
        $page       = ($page < 1) ?  1 : $page;
        $start      = ($page - 1) * $perpage;

        $listcount = $this->modelUsers->count();
        $userlist = $this->modelUsers->order('uid')->limit($start,$perpage)->select();

        //获取用户所属组的名称

        foreach($userlist as $k=>&$v){
            $groupNameArr = $this->modelUsers->getUserGroupInfo($v['uid'] , 'title');
            $groupNameStr= is_array($groupNameArr)?implode(',',$groupNameArr ):'';
            $v[groupname] = $groupNameStr;
        }
        $theurl = url('user/index');
        $multipage = multi($listcount, $perpage, $page, $theurl); //分页处理

        $this->assign('title',$title);
        $this->assign('userlist',$userlist);
        $this->assign('multipage',$multipage);
        return $this->fetch();

    }

    public function profile()
    {
        $title = 'My panel';
        $params['op'] = 'getuserinfo';
        $params['uid'] = $this->getSysConfValue('app_key');
        $res = api_request('get' ,api_build_url('api.php',$params));
        $finndy_info = check_api_result($res);
        if(!empty($finndy_info['robotversion'])){
            $params['op'] = 'getversiontolv';
            $params['version'] = $finndy_info['robotversion']; //$userinfo['finndy_uid'];
            $res_lv = api_request('get' ,api_build_url('api.php',$params));
            $result_lv = check_api_result($res_lv);
        }
        //获取用户组
        $groupNameArr = $this->modelUsers->getUserGroupInfo($this->uid , 'title');
        $groupNameStr= is_array($groupNameArr)?implode(',',$groupNameArr ):'';
        $this->assign('finndy',$finndy_info);
        $this->assign('lv',$result_lv);
        $this->assign('groupNameStr',$groupNameStr);
        return $this->fetch('profile',['title'=>$title]);
    }

    public function resetpwd()
    {

        $title = 'Change Password';
        if(request()->isPost()){
            $postdata = input();

            $validate = $this->validate($postdata,'User.Resetpwd');//使用validate验证
            if(true !== $validate){
                // 验证失败 输出错误信息
                $this->error($validate);
            }
            if($postdata['set_newpass'] != $postdata['set_okpass']){$this->error('The new password is not consistent in two times!');}

            $userinfo =$this->modelUsers->getInfo(['username'=>$this->getInfo('username'),'password'=>passwordencrypt($postdata['set_oldpass'])]);
            if(empty($userinfo)){$this->error('Original password error!');}

            $updage_res = $this->modelUsers->setUserValue(array('uid'=>$userinfo['uid']),'password',passwordencrypt($postdata['set_okpass']));
            if(!$updage_res){
                $this->error('Fail!');
            }
            $this->success('Success, please login.','login/loginout');
        }
        return $this->fetch('resetpwd',['title'=>$title]);
    }

    //增加用户
    public function add()
    {
        if(request()->isPost()) {
            $data = input();
            $validate = $this->validate($data, 'User.AddUser');
            if (true !== $validate) {
                // 验证失败 输出错误信息
                $this->error($validate);
            }
            $groupidarr = $data['group_ids'];
            if(empty($groupidarr)){
                $this->error('Please select User Group');
            }

            $data['password'] = passwordencrypt($data['password']);
            $user_info = $this->modelUsers->getInfo(array('username'=>$data['username']));
            if($user_info){
                $this->error('The user name already exists!');
            }



            $this->modelUsers->insertData($data);
            $insert_id = $this->modelUsers->getLastInsID();
            //自增id
            if(!$insert_id){
                $this->error('The operation failed. Try again later!');
            }
//            //插入到auth_group_access 表中
            if (!empty($data['group_ids'])) {
                foreach ($data['group_ids'] as $k => $v) {
                    $group=array(
                        'uid'=>$insert_id,
                        'group_id'=>$v,
                    );
                    $authgroupaccess = new AuthGroupAccess();
                    $authgroupaccess->insertData($group);
                }
            }
            $this->success('Added successfully','user/index');
        }
        //获取用户组
        $authgroup = new \app\admin\model\AuthGroup();
        $authgroupres = $authgroup->select();
        $this->assign('authgroupres',$authgroupres);
        return $this->fetch();
    }
    //修改用户信息
    public function edit()
    {
        if(request()->isPost()) {
            $data = input();
            // dump($data);die;
            $uid = $data['uid'];
            $groupidarr = $data['group_ids'];
            if(empty($groupidarr)){
                $this->error('Please select User Group');
            }
            if(empty($uid)){$this->error('Parameter error!');}

            $password = $data['password'];
            if(empty($password)){$data['password'] = 123456;} //默认填充密码，提交时不修改

            $validate = $this->validate($data, 'User.AddUser');
            if (true !== $validate) {
                // 验证失败 输出错误信息
                $this->error($validate);
            }
            if(empty($password)){
                unset($data['password']); //剔除默认密码，不提交
            }else{
                $data['password'] = passwordencrypt($password);
            }

            //dump($data);die;
            $inser_res = $this->modelUsers->updateData($data);
            if($inser_res === ''){
                $this->error('The operation failed. Try again later!');
            }

            //同时 更新 group_access 表 先删除后添加
            $authgroupaccess = new AuthGroupAccess();
            $res = $authgroupaccess->where(array('uid'=>$uid))->delete();
            if (!empty($groupidarr)) {
                foreach ($groupidarr as $k => $v) {
                    $group=array(
                        'uid'=>$uid,
                        'group_id'=>$v,
                    );
                    $authgroupaccess = new AuthGroupAccess();
                    $authgroupaccess->insertData($group);
                }
            }
            $this->success('Success','user/index');
        }

        $uid = intval(input('param.uid'));
        if(empty($uid)){
            $this->error('Wrong parameter!');
        }
        //获取用户组
        $authgroup = new \app\admin\model\AuthGroup();
        $authgroupres = $authgroup->select();


        //获取该用户信息
        $userinfo = $this->modelUsers->getInfo(array('uid' => $uid));
        //获取用户所属组的id
        $groupIdArr = $this->modelUsers->getUserGroupInfo($uid );

        $userinfo[group_id] = $groupIdArr;
        $this->assign('userinfo',$userinfo);
        $this->assign('authgroupres',$authgroupres);
        return $this->fetch();
    }
    //删除用户
    public function del()
    {
        $data = input();
        $uid = intval($data['uid']);
        if(empty($uid)){
            $this->error('Wrong parameter!');
        }
        if($uid == 1){
            $this->error('Super administrator cannot delete!');
        }
        $res = $this->modelUsers->delUser(array('uid'=>$uid));
        if(!$res){
            $this->error('The operation failed. Try again later!');
        }
        //删除用户用户组关联表中auth_group_access的数据
        $authgroupaccess = new AuthGroupAccess();
        $authgroupaccess->where('uid' , $uid)->delete();
        $this->success('Successfully deleted','user/index');

    }

    //禁用用户
    public function ban()
    {
        $data = input();
        $uid = $data['uid'];
        $status = $data['status'];
        if(strlen($status) != 1 || !intval($status)){$this->error('Error!');}
        if($status  != 0){
            $status = 0;
        }else{
            $status = 1;
        }
        if(empty($uid)){$this->error('Error!');}

        $status_res =$this->modelUsers->setUserValue(array('uid'=>$uid),'status',$status);
        if(!$status_res){
            $this->error('Fail!');
        }
        $this->success('Success','user/index');

    }




}
