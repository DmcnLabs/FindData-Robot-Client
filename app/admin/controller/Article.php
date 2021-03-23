<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\ArticleCategory as CategoryModel;


class Article extends Base
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->modelArticle = new ArticleModel();

    }

    public function index()
    {
        $title = 'Article list';
        $listcount = $this->modelArticle->count();
        $page = empty(input('get.page')) ? 1 :input('get.page');
        $page = ($page < 1) ?  1 : $page;
        $perpage    = config('pagesize');
        $start = ($page - 1) * $perpage;
        $limit = $start.','.$perpage;
        $where = array('a.uid'=>$this->uid);
        $articleres = $this->modelArticle->getArticleList($where,$limit);
        $theurl = url('article/index');
        $multipage = multi($listcount, $perpage, $page, $theurl); //分页处理
        $this->assign('articleres' ,$articleres);
        $this->assign('title' ,$title);
        $this->assign('multipage',$multipage);
        return $this->fetch('index');
    }

    public function add()
    {
        if(request()->isPost()) {
            $data = input();


            $validate = $this->validate($data, 'Article.add');
            if (true !== $validate) {
                $this->error($validate);
            }
            //发布,置顶,推荐 复选框处理
            if(!empty($data[post])){
                foreach($data[post] as $key => $val){
                    $data[$key] = $val;
                }
            }
            unset($data[post]);
            if(empty(intval($data['cateid']))){
                $this->error('Please select category');
            }
            $data['uid'] = $this->uid;
            $data['create_time'] = time();


            $res =$this->modelArticle ->addArticle($data);
            if($res < 1){
                $this->error($this->modelArticle->error);
            }
            if($res){
                $this->success('The article was added successfully',url('index'));
            }else{
                $this->error('Failed to add article!');
            }
        }
        $categoryModel = new CategoryModel();
        $categoryRes = $categoryModel->getList('sort');
        $title= 'Add article';
        $this->assign('categoryRes' ,$categoryRes);
        $this->assign('title' ,$title);
        return $this->fetch();
    }

    public function edit()
    {
        if(request()->isPost()) {
            $data = input();
            //dump($data);die;
            $validate = $this->validate($data, 'Article.edit');
            if (true !== $validate) {
                // 验证失败 输出错误信息
                $this->error($validate);
            }

            if($data[thumb]){
                $arts=$this->modelArticle->find($data['id']);
                $old_thumb=$_SERVER['DOCUMENT_ROOT'].$arts['thumb'];

                if(file_exists($old_thumb)){
                    @unlink($old_thumb);
                }
            }else{
                $data[thumb] = $data['thumb_old'];
            }


            //旧图




            //发布,置顶,推荐 复选框处理
            if(!empty($data[post])){
                foreach($data[post] as $key => $val){
                    $data[$key] = $val;
                }
            }
            unset($data[post]);

           // dump($data);die;
            $res = $this->modelArticle->editArticle($data);
            if($res < 1){
                $this->error('Update failed');
            }



            $this->success('update success!','index');
        }

        $articleId = intval(input('param.id'));
        if(empty($articleId)){
            $this->error('Wrong parameter');
        }
        $categoryModel = new CategoryModel();
        $categoryRes = $categoryModel->getList('sort');
        $articles = $this->modelArticle->find($articleId);

        $title= 'Edit article';
        $this->assign('categoryRes' ,$categoryRes);
        $this->assign('articles' ,$articles);
        $this->assign('title' ,$title);
        return $this->fetch();

    }
    public function del()
    {
        $articleId = intval(input('param.id'));
        if(empty($articleId)){
            $this->error('Wrong parameter');
        }
        $res = $this->modelArticle->delArticle($articleId);
        if($res < 1){
            $this->error('Failed to delete the article!');
        }
        $tagAccessModel = new \app\admin\model\ArticleTagAccess;
        $tagAccessModel->where('articleid',$articleId)->delete();
        $this->success('Delete the article successfully!',url('index'));
    }

    //是否发布
    public function post()
    {
        if(request()->isAjax()){
            $data = input();
            if(count($data) < 1){
                return false;
            }
            $result = array();
            $artId = $data['id'];
            $status = $data['status'];
            if($status == 1){
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'poststatus', 0);
                if($res){
                    $result['status'] = 0;
                    $result['icon'] = 'ace-icon fa fa-close';
                    $result['msg'] = 'Unpublish';
                }
            }else{
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'poststatus', 1);
                if($res){
                    $result['status'] = 1;
                    $result['icon'] = 'ace-icon fa fa-check';
                    $result['msg'] = 'Published';
                }
            }
            return json($result);
        }
    }
    //是否置顶
    public function top()
    {
        if(request()->isAjax()){
            $data = input();

            if(count($data) < 1){
                return false;
            }
            $result = array();
            $artId = $data['id'];
            $status = $data['status'];
            if($status == 1){
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'is_top', 0);
                if($res){
                    $result['status'] = 0;
                    $result['icon'] = 'fa fa-arrow-down';
                    $result['msg'] = 'Cancel top';
                }
            }else{
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'is_top', 1);
                if($res){
                    $result['status'] = 1;
                    $result['icon'] = 'fa fa-arrow-up';
                    $result['msg'] = 'Its on top';
                }
            }
            return json($result);
        }
    }
    //是否推荐
    public function recommend()
    {
        if(request()->isAjax()){
            $data = input();
           // dump($data);die;
            if(count($data) < 1){
                return false;
            }
            $result = array();
            $artId = $data['id'];
            $status = $data['status'];
            if($status == 1){
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'recommended', 0);

                if($res){
                    $result['status'] = 0;
                    $result['icon'] = ' fa fa-thumbs-down';
                    $result['msg'] = 'Cancel recommendation';
                }
            }else{
                $res = $this->modelArticle->setAritcleValue(array('id'=>$artId) , 'recommended', 1);
                if($res){
                    $result['status'] = 1;
                    $result['icon'] = ' fa fa-thumbs-up';
                    $result['msg'] = 'Recommended';
                }
            }
            return json($result);
        }
    }

    //多图上传处理
    public function upload()
    {
        $typeArr = array("jpg", "png", "bmp",'jpeg');//允许上传文件格式
        $file_save_method = config('file_save_method');

        if($file_save_method === 0){//存储本地服务器
            $file = request()->file('file');
            $info = $file->validate(['size'=>config('uploadmaxsize'),'ext'=>'jpg,png,bmp,jpeg'])->move(UPLOAD_PATH);
            if($info){
                $imgName = $info->getSaveName();
                $configPath = config('view_replace_str');
                $pic_url = request()->domain().$configPath['__PUBLIC__'].'/uploads/'. $imgName;
                $savepath = '/uploads/'. $imgName;

    //                $result['status'] = true;
    //                $result['attrs']['data-server-file'] = true;
    //                $result['attrs']['data-delete-url'] = $_SERVER['DOCUMENT_ROOT'].'/'.$imgName;
    //                $result['attrs']['data-delete-url'] = $pic_url;
    //                $result['attrs']['savepath'] = $savepath;
    //                $result['attrs']['name'] = $imgName;
    //                $result['attrs']['picpath'] = $pic_url;
    //                $result['type'] = $uploadType;

                return json(array("error"=>"0","picpath"=>$pic_url,"name"=>$imgName,"savepath"=>$savepath));
            }else{
                return json(array("error"=>$file->getError()));
            }
        }else{//上传到云端服务器 oss  七牛
            $file = $_FILES['file'];
            $type = explode('/' , $file['type']);
            $type = $type[1];
            if (!in_array($type, $typeArr)) {
                return json(array("error"=>"Please upload JPG, PNG, BMP or JPEG images!"));
                exit;
            }
            if ($file['size'] > (config('uploadmaxsize'))) {
                return json(array("error"=>"The image size has exceeded 2m!"));
                exit;
            }

            $info = oss_upload_file($file['name'],$file['tmp_name']);
            if($info){
                $imgName = $info['savePath'];
                $totalTime = $info['totalTime'];
                $savepath = $info['savePath'];
                $pic_url = oss_display_image($savepath,1);
                return json(array("error"=>"0","picpath"=>$pic_url,"name"=>$imgName,"savepath"=>$savepath,"totalTime"=>$totalTime));
            }else{
                return json(array("error"=>"Upload error, check the server configuration!"));
            }
        }
    }

    //删除文件
    public function removeFile()
    {
        if(request()->isAjax()){
            $fileName = input('get.fileName');
            $file_save_method = config('file_save_method');
            $result = array();
            if( $file_save_method === 0){
                $file=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$fileName;
                $result = array();
                if(file_exists($file)){
                    @unlink($file);
                    $result['msg'] = 'ok';
                }else{
                    $result['msg'] = 'fail';
                }
            }else{
                $res = oss_remove_file($fileName);

                if($res){
                    $result['msg'] = 'ok';
                }else{
                    $result['msg'] = 'fail';
                }
            }
            return json($result);
        }
    }
}
