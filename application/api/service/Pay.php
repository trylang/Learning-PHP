<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/26
 * Time: 20:15
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Loader;
use think\Log;

// 手动加载引入没有命名空间的文件，用于使用文件下面的类
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if(!$orderID) {
            throw new Exception('订单号不允许为空');
        }
        $this->orderID = $orderID;
    }

    // 支付主方法
    public function pay() {
        // 订单号可能就根本不存在
        // 订单号确实存在，但是订单号和当前用户不匹配
        // 订单有可能已经被支付过
        // 进行库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass']) {
            return $status;
        }

    }

    // 发送微信预定单
    private function makeWxPreOrder($totalPrice) {
        // openid
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid) {
            throw new TokenException();
        }
        // 微信统一下单
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        // 异步回调方法，传入回调方法名
        $wxOrderData->SetNotify_url('');
    }

    // 获取订单签名
    private function getPaySignature($wxOrderData) {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
    }

    private function checkOrderValid() {
        $order = OrderModel::where('id', '=', $this->orderID)
            ->find();
        if(!$order) {
            throw new OrderException();
        }
        if(!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
               'msg' => '订单与用户不匹配',
               'errorCode' => 10003
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
               'msg' => '订单已支付过啦',
               'errorCode' => 80003
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}

















































