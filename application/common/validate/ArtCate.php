<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/9
 * Time: 22:36
 */

namespace app\common\Validate;

use think\Validate;
class ArtCate extends Validate
{
    protected $rule=[
        'name|栏目名称'=>'require|length:3,20|chsAlpha',
    ];


}