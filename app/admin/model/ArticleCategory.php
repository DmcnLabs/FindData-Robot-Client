<?php
namespace app\admin\model;
use think\Model;



class ArticleCategory extends  ModelBase
{
    protected $name = 'article_category';

    /** 查询制定字段的值
     * @param array $where
     * @param $field
     * @return array|false|\PDOStatement|string|Model
     */
    public function getCategoryValue(array $where, $field)
    {
       $data = $this->where($where)->field($field)->select();
       return $data;
    }

    /**
     * 数据排序
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($data,$id='id',$order='sort'){

        foreach ($data as $key => $val) {
            if($this->where(array($id=>$key))->setField('sort',$val)){
                $result = true;
            }
        }
        return $result;
    }





    /**根据 当前id 来获取该条数据下面子级的id
     * @param $authCategoryid
     * @return array id 数组
     */
    public function getChilrenId($authCategoryId)
    {
        $authCategoryRes = $this->select();
        return $this->_getChilrenId($authCategoryRes,$authCategoryId);
    }

    public function _getChilrenId($authCategoryRes,$authCategoryId)
    {
        static $arr=array();
        foreach ($authCategoryRes as $k => $v) {
            if($v['pid'] == $authCategoryId){
                $arr[]=$v['id'];
                $this->_getChilrenId($authCategoryRes,$v['id']);
            }
        }
        //asort($arr);
        return $arr;
    }

    /**获取分类列表 树状结构
     * @return array
     */
    public function getList($order='')
    {
        if(empty($order)){
            $authRes = $this->select();
        }
        $authRes = $this->order($order)->select();
        $authRes = collection($authRes)->toArray();
        return $this->sort($authRes);
    }

    /**根据pid 递归查询 权限
     * @param $authRes
     * @param int $pid
     * @return array
     */
    public function sort($authRes , $pid=0)
    {
        static $arr = array();
        foreach($authRes as $k => $v){
            if($v['pid'] == $pid ){
                $arr[] = $v;
                $this->sort($authRes , $v['id']);
            }
        }
        return $arr;
    }


}
