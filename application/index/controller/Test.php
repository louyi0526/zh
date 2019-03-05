<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 0:41
 */

namespace app\index\controller;

use app\common\controller\Base;
class Test extends Base
{
    //测试用的验证器
    public function test1()
    {
        $data = [
            'name'=>'zhuzz',
            'email'=>'123@qq.com',
            'mobile'=>'15958155732',
            'password'=>'123dfdfd',
        ];
        $rule = 'app\common\validate\User';

        return $this->validate($data,$rule);
    }
}