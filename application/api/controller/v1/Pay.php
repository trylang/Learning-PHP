<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/26
 * Time: 19:59
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;

use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id='') {
        (new IDMustBePostiveInt()) -> goCheck();
        $pay = new PayService();
        $pay->pay($id);
    }

    public function receiveNotify() {
        // 通知频率为15/15/30/180/1800/1800/1800/3600. 单位为秒
        //1. 检查库存量（第三次），超卖
        //2. 更新这个订单的status状态
        //3. 减库存
        //4. 如果成功处理，返回微信成功处理的消息，否则我们需要返回没有成功处理

        // 特点： post：xml格式：不会携带参数
        $notify = new WxNotify();

        // 这里调用的是WxNotify的基类方法，因为handle方法封装好了调用参数的信息。所以，先提前加载handle方法
        $notify->Handle();
    }

}







































