<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 11:09
 */

// 1. 关于thinkPHP的扩展配置项，会自动读取的配置，默认是在application下新建的extra文件夹下

// 2. 关于图片路径img_prefix, 'http://z.cn' 对应项目的路径是zerg下的public，不是zerg。
//thinkPHP中只有public目录是可以公开访问的，不需要权限，图片images的静态资源也是放在public目录下，而不能是其他地方。
// 如果把images图片资源放在pubic之外的地方，是没办法访问的。

// 3. 获取配置信息的方法用TP5自带的方法config， $imagesUrl = config('setting.img_prefix');


return [
  'img_prefix' => 'http://z.cn/images',
  'token_expire_in' => 7200
];