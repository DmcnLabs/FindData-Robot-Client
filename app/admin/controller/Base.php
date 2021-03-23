<?php
namespace app\admin\Controller;

use think\Session;
use think\Log;
use app\common\controller\Bbase;
use app\admin\model\SysConf as modelSysConf;
use app\admin\model\AuthRule as modelAuthRule;
use think\cache;

class Base extends  Bbase
{
    public $uid = 0;
   
    protected function _initialize()
    {

        parent::_initialize();
        $this->uid = $this->getUserInfo('uid');
        if(!$this->uid || !$this->getUserInfo()){
            $this->error('You are not logged into the system',url('login/dologin'));
        }
        //权限校验
        if(!$this->checkAccess()){
            $this->error('No permission',url('index/index'));
        }
        if(empty($this->getSysConfValue('app_key'))||empty($this->getSysConfValue('app_secret'))){
           if(in_array($this->request->controller(),array('Robot'))){
               $this->error('Please configure cloud account information first',url('Sysconf/SysSet'));
           }
        }
        $this->setPageSeo();
        $this->assign('currentAction',strtolower($this->request->controller().'/'.$this->request->action()));
        //根据权限判断是否显示菜单 有权限则显示
        $modelAuthRule = new modelAuthRule();
        $menuArr = $modelAuthRule->getTreeData( array('is_display'=> 1));
        $this->assign('menuArr',$menuArr);
    }
    /**判断权限
     * @param $uid 用户id
     * @return bool
     */
    protected function checkAccess()
    {
        $controller=$this->request->controller();
        $action=$this->request->action();
        $name=$controller.'/'.$action;
        $notCheck=array('Index/index','Login/doLogin','Login/loginOut','Robot/policy');
        if($this->uid != 1){
            if(!in_array($name , $notCheck ,false)){
                return authCheck($name , $this->uid);
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    /**获取所有系统配置信息
     * @return array|mixed
     */
    protected function getSysConf(){
       $modelSysConf = new modelSysConf();
       $sys_conf = $modelSysConf->getSysConf();
       return $sys_conf;
    }

    /**获取单个系统配置信息
     * @param string $key
     * @return bool
     */
    protected function getSysConfValue($key='app_key'){
        if(empty($key))return false;
        $sys_conf = $this->getSysConf();
        if(!isset($sys_conf[$key]))return false;
        return $sys_conf[$key];
    }

    /**系统SEO配置信息*/
    protected function setPageSeo(){
        $seoInfo['title']=$this->getSysConfValue('web_site_title');
        $seoInfo['kw']=$this->getSysConfValue('web_site_keyword');
        $seoInfo['desc']=$this->getSysConfValue('web_site_description');
        $this->assign('seoInfo',$seoInfo);
    }

    protected function checkUserType($userTypeNew=''){
        $userInfo = Session::get('userinfo');
        $userType = $userInfo['user_type'];
        if(empty($userTypeNew)||($userType<2)||($userTypeNew>$userType)){
            $this->error('No permission');
        }
    }

    protected function getUserInfo($key=''){
        $userInfo = Session::get('userinfo');
        if(!empty($key)){
            if(isset($userInfo[$key])){
                $res = $userInfo[$key];
            }else{
                $res =false;
            }
        }else{
            $res = $userInfo;
        }
            
        return $res;
        }
    



}
