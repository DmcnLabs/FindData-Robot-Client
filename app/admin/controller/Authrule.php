<?php
namespace app\admin\controller;
use app\admin\model\AuthRule as AuthRuleModel;
use \think\cache;

class Authrule extends Base
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->modelAuthRule = new AuthRuleModel();
    }

    public function Index()
    {
        $title = 'Permission setting';

        $authRuleres = $this->modelAuthRule->getRuleFormatList();
        $this->assign('authruleres' ,$authRuleres);
        $this->assign('title' ,$title);
        return $this->fetch('index');
    }

    public function add()
    {
        if(request()->isPost()) {
            $data = input();
            $validate = $this->validate($data, 'AuthRule.add');
            if (true !== $validate) {
                // 验证失败 输出错误信息
                $this->error($validate);
            }

            //判断规则是否已存在
            if($this->modelAuthRule->getInfo(array('name' => $data['name']) )){
                $this->error('The rule already exists. Please re-enter');
            }
            $pid = $data['pid'];
            $where = array('id'=>$pid);
            $level = $this->modelAuthRule->getRuleValue($where , 'level');
            if($level){
                $data['level'] = $level[0]['level'] + 1;
            }else{//顶级权限
                $data['level'] = 0;
            }
            $res = $this->modelAuthRule->insertData($data);
            if(!$res){
                $this->error('Operation failed, try again later!');
            }
            $this->success('New permission succeeded!','index');
        }

        $authruleres = $this->modelAuthRule->getRuleFormatList();
        $title= 'Tagging';
        $this->assign('authruleres' ,$authruleres);
        $this->assign('title' ,$title);
        return $this->fetch();

    }

    public function edit()
    {
        if(request()->isPost()) {
            $data = input();
            $validate = $this->validate($data, 'AuthRule.edit');
            if (true !== $validate) {
                // 验证失败 输出错误信息
                $this->error($validate);
            }
            //判断是否显示菜单复选框按钮的值
            $_data = array();
            foreach ($data as $k=>$v){
                $_data[] = $k;
            }
            if(!in_array('is_display' , $_data)){
                $data['is_display'] = 0;
            }

            $id = $data['id'];
            $pid = $data['pid'];
            $where = array('id'=>$pid);
            $level = $this->modelAuthRule->getRuleValue($where , 'level');
            if($level){
                $data['level'] = $level[0]['level']+1;
            }else{//顶级权限
                $data['level'] = 0;
            }
            $res = $this->modelAuthRule->updateData($data);
            if(!$res){
                $this->error('Data has not changed, update failed!');
            }
            $this->success('update success!','index');

        }
        $ruleid = intval(input('param.ruleid'));
        if(empty($ruleid)){
            $this->error('Wrong parameter');
        }
        $title = 'Edit permission';
        $authruleres = $this->modelAuthRule->getRuleList();
        $authrules = $this->modelAuthRule->find($ruleid);
        $this->assign('title' ,$title);
        $this->assign('authruleres' ,$authruleres);
        $this->assign('authrules' ,$authrules);

        return $this->fetch();

    }
    //排序
    public function sort()
    {
        $data = input('post.');
        $res = $this->modelAuthRule->updateOrderData($data);
        if(!$res){
            $this->error('Data has not changed, sorting failed！');
        }
        $this->success('update success');
    }

    public function del()
    {
        $ruleId = intval(input('param.ruleid'));
        $ruleArr = $this->modelAuthRule->getChilrenId($ruleId);
        $ruleArr[] = $ruleId;
        $res = AuthRuleModel::destroy($ruleArr);

        if(!$res){
            $this->error('Failed to delete permission!');
        }
        //$this->redirect(url('index'));
        $this->success('Delete permission successfully!',url('index'));

    }


}
