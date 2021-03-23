<?php
namespace app\admin\model;
use think\Model;

class UserRobot extends  ModelBase
{

    protected $name = 'user_robot';


    /**获取用户所发布的数据源id
     * @param array $where
     */
    public function getRobotid(array $where){
        return  $this->where($where)->column('robotid');
    }








}

