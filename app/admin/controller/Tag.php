<?php
namespace app\admin\controller;
use app\admin\model\ArticleTag as TagModel;

class Tag extends Base
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->modelTag = new TagModel();
    }

    public function Index()
    {
        $title = 'Tag list';
        $listcount = $this->modelTag->count();
        $perpage = config('pagesize');
        $page = empty(input('get.page'))?1:input('get.page');
        $page = ($page <1)? 1:$page;
        $star = ($page -1)*$perpage;
        $limit = $star.','.$perpage;
        $theurl = url('Tag/index');
        $tagRes = $this->modelTag->limit($limit)->select();

        $multipage = multi($listcount, $perpage, $page, $theurl); //分页处理
        $this->assign('tagRes' ,$tagRes);
        $this->assign('multipage' ,$multipage);
        $this->assign('title' ,$title);
        return $this->fetch('index');
    }

    public function add()
    {
        if(request()->isPost()) {
            $data = input();

            if(empty(trim($data['name'])) ){
                $this->error('Label name cannot be empty');
            }
            //判断规则是否已存在
            if($this->modelTag->getInfo(array('name' => $data['name']) )){
                $this->error('The label already exists, please re-enter');
            }
            $res = $this->modelTag->insertData($data);
            if(!$res){
                $this->error('Operation failed, try again later!');
            }
            $this->success('Label added successfully!','index');
        }
        $title= 'Tagging';
        $this->assign('title' ,$title);
        return $this->fetch();
    }

    public function edit()
    {
        if(request()->isPost()) {
            $data = input();
            if(empty(trim($data['name'])) ){
                $this->error('Label name cannot be empty');
            }
            if($this->modelTag->getInfo(array('name' => $data['name']) )){
                $this->error('The label already exists, please re-enter the');
            }
            $res = $this->modelTag->updateData($data);
            if(!$res){
                $this->error('Data has not changed, update failed!');
            }
            $this->success('update success!','index');
        }
        $tagId = intval(input('param.id'));
        if(empty($tagId)){
            $this->error('Wrong parameter');
        }
        $title = 'Edit label';
        $tags = $this->modelTag->find($tagId);
        $this->assign('title' ,$title);
        $this->assign('tags' ,$tags);
        return $this->fetch();
    }

    public function del()
    {
        $tagId = intval(input('param.id'));
        if(empty($tagId)){
            $this->error('Wrong parameter');
        }
        $res = TagModel::destroy($tagId);
        if(!$res){
            $this->error('Delete failed!');
        }
        $this->success('Delete successfully!',url('index'));
    }


}
