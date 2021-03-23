<?php
namespace app\admin\controller;
use app\admin\model\ArticleCategory as CategoryModel;

class Category extends Base
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->modelCategory = new CategoryModel();
    }

    public function Index()
    {
        $title = 'Classification list';
        $categoryRes = $this->modelCategory->getList('sort');
        $this->assign('categoryRes' ,$categoryRes);
        $this->assign('title' ,$title);
        return $this->fetch('index');
    }

    public function add()
    {
        if(request()->isPost()) {
            $data = input();
            if(empty(trim($data['name']))){
                $this->error('Category name cannot be empty');
            }
            //判断规则是否已存在
            if($this->modelCategory->getInfo(array('name' => $data['name']) )){
                $this->error('The category already exists, please re-enter');
            }
            $pid = $data['pid'];
            $where = array('id'=>$pid);
            $level = $this->modelCategory->getCategoryValue($where , 'level');
            if($level){
                $data['level'] = $level[0]['level'] + 1;
            }else{//顶级分类
                $data['level'] = 0;
            }
           // $data['create_time'] = time();
            $res = $this->modelCategory->insertData($data);
            if(!$res){
                $this->error('The operation failed. Try again later!');
            }
            $this->success('New category added successfully!','index');
        }
        $categoryRes = $this->modelCategory->getList('sort');
        $title= 'Add category';
        $this->assign('categoryRes' ,$categoryRes);
        $this->assign('title' ,$title);
        return $this->fetch();
    }

    public function edit()
    {
        if(request()->isPost()) {
            $data = input();
            if(empty(trim($data['name']))){
                $this->error('Category name cannot be empty');
            }

            $pid = $data['pid'];
            $where = array('id'=>$pid);
            $level = $this->modelCategory->getCategoryValue($where , 'level');
            if($level){
                $data['level'] = $level[0]['level']+1;
            }else{//顶级分类
                $data['level'] = 0;
            }

            $res = $this->modelCategory->updateData($data);
            if(!$res){
                $this->error('Data has not changed, update failed!');
            }
            $this->success('update success!','index');
        }
        $categoryId = intval(input('param.id'));
        if(empty($categoryId)){
            $this->error('Wrong parameter');
        }
        $title = 'Edit category';
        $categoryRes = $this->modelCategory->getList('sort');
        $categorys = $this->modelCategory->find($categoryId);
        $this->assign('title' ,$title);
        $this->assign('categoryRes' ,$categoryRes);
        $this->assign('categorys' ,$categorys);
        return $this->fetch();
    }
    //排序
    public function sort()
    {
        $data = input('post.');
        $res = $this->modelCategory->orderData($data);
        if(!$res){
            $this->error('Data has not changed, sorting failed！');
        }
        $this->success('update success');
    }


    public function del()
    {
        $categoryId = intval(input('param.id'));
        if(empty($categoryId)){
            $this->error('Wrong parameter');
        }
        $categoryArr = array();
        $categoryArr = $this->modelCategory->getChilrenId($categoryId);
        $categoryArr[] = $categoryId;
        if(count($categoryArr) < 1){
            $this->error('Wrong parameter');
        }
        $res = CategoryModel::destroy($categoryArr);
        if(!$res){
            $this->error('Failed to delete classification!');
        }
        $this->success('Delete classification successfully!',url('index'));
    }


}
