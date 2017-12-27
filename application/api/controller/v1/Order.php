<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/15
 * Time: 16:50
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;

use app\api\validate\PagingParameter;

class Order extends BaseController
{
    // 用户在选择商品后，向API提交包含它所选择商品的相关信息
    // API在接收到信息后，需要检查顶端相关商品的库存量 （第一次）
    // 有库存，把订单数据存入数据库。下单成功了，返回客户端消息，告诉客户端可以支付了
    // 调用我们的支付接口，进行支付
    // 还需要再次进行库存量检测 （第二次）
    // 服务器这边就可以调用微信的支付接口进行支付
    // 小程序根据服务器返回的结果拉起微信支付
    // 微信会返回给我们一个支付的结果（异步）
    // 成功：也需要进行库存量的检测 （第三次）
    // 成功：进行库存量的扣除

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
    ];

    // 下单接口
    public function placeOrder() {
        (new OrderPlace())->goCheck();

        // 用户输入的商品信息
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    // 分页查询与获取用户历史订单数据
    public function getSummaryByUser($page=1, $size=15) {
        (new PagingParameter())->goCheck();
        $uid = \app\api\service\Token::getCurrentUID();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if(!$pagingOrders->isEmpty()) {
            return [
              'data' => [],
              'current_page' => $pagingOrders->currentPage()
            ];
        }
        $data = $pagingOrders
            ->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->currentPage()
        ];
    }

    /**
     * 获取订单详情
     * @param $id
     * @return static
     * @throws OrderException
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail)
        {
            throw new OrderException();
        }
        return $orderDetail
            ->hidden(['prepay_id']);
    }

















}