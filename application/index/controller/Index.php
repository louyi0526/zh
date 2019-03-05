<?php
namespace app\index\controller;

use app\common\controller\Base;
class Index extends Base
{
    public function index()
    {
        $this->assign('name','123123123');
        return $this->fetch();
    }


}
