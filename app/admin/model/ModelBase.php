<?php
namespace app\admin\model;
use think\Model;



class ModelBase extends  Model
{

    // 关闭自动写入update_time字段
    protected $updateTime = false;



    /**插入数据
     * @param array $data
     * @return int|string
     */
    public function insertData(array $data)
    {
        return $this->allowField(true)->data($data)->save();
    }
    /**更新数据
     * @param array $data
     * @return int|string
     */
    public function updateData(array $data)
    {
        return  $this->allowField(true)->isUpdate(true)->data($data, true)->save();
    }

    /**按条件查询信息
     * @param array $where 条件
     * @return array|bool|false|\PDOStatement|string|Model
     */
    public function getInfo(array $where){
        if(!is_array($where)) return false;
        return  $this->where($where)->find();
    }


}
