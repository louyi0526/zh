<?php

namespace app\admin\common\Validate;

use think\Validate;
class ArtCate extends Validate
{
    protected $rule=[
        'name|栏目名'=>'require|length:3,20|chsAlphaNum|unique:article_category',
    ];


}