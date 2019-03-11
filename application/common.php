<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\Db;
//根据用户主键ID,查询
if (!function_exists('getUserName'))
{
    function getUserName($id)
    {
        return Db::table('zh_user')->where('id',$id)->value('name');
    }
}

//过滤文章
function getArtContent($content)
{
    return mb_substr(strip_tags($content),0,5).'>>>';
}

if (!function_exists('getCateName')) {
    function getCateName($cateId)
    {
        return Db::table('zh_article_category')->where('id', $cateId)->value('name');
    }
}
