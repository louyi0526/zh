<?php
//后台入口文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();

//加入口文件需要在config\app改'auto_bind_module'       => true,