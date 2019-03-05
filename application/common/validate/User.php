<?php
/**
 * zh_user表的验证器
 */
namespace app\common\Validate;
use think\Validate;


class User extends Validate
{
    //验证规则在手册验证下内置规则
    protected $rule=[
//        'name|姓名'=>[
//            'require'=>'require',
//            'length'=>'5,20',
//            'chsAlphaNum'=>'chsAlphaNum',
//        ],
//        'password|密码'=>[
//            'require'=>'require',
//            'length'=>'6,20',
//            'alphaNum'=>'alphaNum',
//            'confirm'=>'confirm',//会自动验证和password_confirm进行字段比较是否一致
//        ],
//        'email|邮箱'=>[
//            'require'=>'require',
//            'email'=>'email',
//            'unique'=>'zh_user',//该规则是此字段必须在zh_user表中唯一的
//        ],
//        'mobile|手机'=>[
//            'require'=>'require',
//            'mobile'=>'mobile',
//            'unique'=>'zh_user',//该规则是此字段必须在zh_user表中唯一的
//            'number'=>'number',
//        ],

        //验证简写
        'name|姓名'=>'require|length:5,20|chsAlphaNum',
        'email|邮箱'=>'require|email|unique:user',//表内唯一表名前面不要加前缀
        'mobile|手机'=>'require|mobile|unique:user',
        'password|密码'=>'require|length:6,20|alphaNum|confirm',

    ];
}