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
//根据用户主键ID,查询,获取用户名
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

//根据cate主键ID,查询,获取栏目名
if (!function_exists('getCateName')) {
    function getCateName($cateId)
    {
        return Db::table('zh_article_category')->where('id', $cateId)->value('name');
    }
}

if (!function_exists('getFav')) {
    function getFav($art_id)
    {
        if (!session('user_id')){
            return '我要收藏';
        }
        $info = Db::table('zh_user_fav')
            ->where('art_id', $art_id)
            ->where('user_id', session('user_id'))
            ->value('id');
        if (is_null($info)){
            return '我要收藏';
        }else{
            return '取消收藏';
        }

    }
}
if (!function_exists('getLike')) {
    function getLike($art_id)
    {
        if (!session('user_id')){
            return '我要收藏1';
        }
        $info = Db::table('zh_user_like')
            ->where('art_id', $art_id)
            ->where('user_id', session('user_id'))
            ->value('id');
        if (is_null($info)){
            return '我要点赞';
        }else{
            return '取消点赞';
        }

    }
}




