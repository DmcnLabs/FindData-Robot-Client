<?php
namespace app\admin\model;
use think\Db;

class Users extends  ModelBase
{
    /**更新用户的某一个字段$$
     * @param array $where
     * @param $key
     * @param $value
     * @return int
     */
    public function setUserValue(array $where,$key,$value){
        return  $this->where($where)->setField($key,$value);
    }




    /**获取用户列表
     * @param array $where
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getUsers(array $where=[]){
        return $this->where($where)->select();

    }

    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function delUser(array $where=[]){
        if (empty($where)) {
            return false;
        }
        return $this->where($where)->delete();

    }

    public function getUserGroup($groupId=0){
        switch ($groupId){
            case 1:
                $rs= '普通用户';
                break;
            case 2:
                $rs= '管理员';
                break;
            case 3:
                $rs= '超级管理员';
                break;
        }

        return $rs;
    }

    /** 获取用户数
     * @param $where
     */
    public function getUsersCounts($data){
        $userscounts['all'] = $this->count();
        $userscounts['week'] = $this->where('create_time','>',$data)->count();
        return $userscounts;

    }

    /** 查询用户所属组信息
     * @param $uid
     * @param $key 指定字段
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getUserGroupInfo($uid,$key="group_id")
    {
        $res = Db::name('users')
            ->alias('a')
            ->join('auth_group_access b','a.uid = b.uid','left')
            ->join('auth_group c','b.group_id = c.id','left')
            ->where('a.uid' ,$uid)->select();
        if(!$res){
            return false;
        }
        $groupInfoArr = array();
        if(is_array($res)){
            foreach($res as $k => $v){
                $groupInfoArr[] = $v[$key];
            }
        }
        return $groupInfoArr;
    }

}
