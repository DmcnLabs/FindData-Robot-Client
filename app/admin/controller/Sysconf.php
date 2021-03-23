<?php
namespace app\admin\controller;

use app\admin\model\SysConf as modelSysConf;
class Sysconf extends Base
{
    public function Index()
    {
        $title = 'Permission setting';
        return view('index',['title'=>$title]);
    }


    //系统设置
    public function SysSet()
    {
        if(request()->isPost()) {
            $data = input();
            $this->checkUserType(3);
            if(empty($data['index_url'])){
                $this->error('Website address cannot be empty!');
            }
            if(empty($data['web_site_title'])){
                $this->error('Website Title cannot be empty!');
            }
            //校验appkey配置
            if(!empty($data['app_key'])){
                $params['op'] = 'checkappkey';
                $params['appsecret'] = $data['app_secret'];
                $res = api_request('POST' ,'appkey.php', api_build_params($params,$data['app_key']));
                if($res['error_code'] != 0){
                    $this->error('Incorrect authorization appkey or appsecret!');
                }
            }
            //获取个人信息
            $params['op'] = 'getuserinfo';
            $res = api_request('get' , api_build_url('api.php',$params));
            $theuser = check_api_result($res);

            //开启本地存储
            if($data['save_method'] == 1){
                if($theuser['cloud_url'] == '' ){
                    $this->error('Please go to the official website to set up siteurl');
                }
                if($theuser['cloud_status'] == 0){
                    $params['op'] = 'changeappstatus';
                    $res = api_request('get' , api_build_url('api.php',$params));
                }
            }else{
                if($theuser['cloud_status'] == 1){
                    $params['op'] = 'changeappstatus';
                    $res = api_request('get' , api_build_url('api.php',$params));
                }
            }

            $modelSysConf = new modelSysConf();
            $modelSysConf->updateSysConf($data);
            $this->success('Success','sysconf/sysset');
        }

        $title = 'System settings';

        $systeminfo = $this->getSysConf();
        $this->assign('systeminfo',$systeminfo);
        $this->assign([
            'title' => $title,
        ]);

        return $this->fetch('sysset');
    }



    //后台菜单设置
    public function MenuSet()
    {
        $title = 'Background menu';
        return view('menuset', ['title' => $title]);
    }
    //增加后台菜单
    public function AddMenu()
    {
        $title = 'Add background menu';
        return view('addmenu', ['title' => $title]);
    }
    //编辑后台菜单
    public function EditMenu()
    {
        $title = 'Edit background menu';
        return view('addmenu', ['title' => $title]);
    }

}
