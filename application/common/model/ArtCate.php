<?php
/**
 * zh_article表的用户模型
 */
namespace app\common\model;
use think\Model;
class ArtCate extends Model
{
    //config\datebase里面可以进行全局设置,如需要单独设置可以以下例为例进行设置,
//    protected $pk = 'id';   //主键,$pk在Db\Query里面
    protected $table = 'zh_article_category';//表名

//    protected $autoWriteTimestamp = true;//开启自动时间戳
//    protected $createTime = 'create_time';//默认字段名称create_time
//    protected $updateTime = 'update_time';//默认字段名称update_time,如果要修改更新的字段名称可以在这里设置

    protected $dateFormat = 'Y年m月d日';//修改更新的字段名称可以在这里设置



    //开始自动设置
    protected $auto = []; //无论是新增或更新都要设置的字段
    //仅新增的有效
    protected $inser = ['create_time','status'=>1];
    //仅更新的有效
    protected $update=['update_time'];

}