<?php
/**
 * zh_user表的用户模型
 */
namespace app\common\model;
use think\Model;
class User extends Model
{
    //config\datebase里面可以进行全局设置,如需要单独设置可以以下例为例进行设置,
//    protected $pk = 'id';   //主键,$pk在Db\Query里面
//    protected $table = 'zh_user';//表名

//    protected $autoWriteTimestamp = true;//开启自动时间戳
//    protected $createTime = 'create_time';//默认字段名称create_time
//    protected $updateTime = 'update_time';//默认字段名称update_time,如果要修改更新的字段名称可以在这里设置

//    protected $dateFormat = 'Y年m月d日';//修改更新的字段名称可以在这里设置




    //获取器
    public function getStatusAttr($val)
    {
        $status = ['1'=>'启用','0'=>'禁用'];
        return $status[$val];
    }

    //获取器
    public function getIsAdminAttr($val)
    {
        $status = ['1'=>'管理员','0'=>'普通会员'];
        return $status[$val];
    }

    //修改器
    public function setPasswordAttr($val)
    {
        return sha1($val);  //加密函数,file文件
    }

}