<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/19
 * Time: 14:33
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    // 订单的商品列表，也就是客户端传递过来的products参数
    protected $oProducts;

    // 真实的商品信息（包含库存量）
    protected $products;

    protected $uid;

    /**
     * @param int $uid 用户id
     * @param array $oProducts 订单商品列表
     * @return array 订单商品状态
     * @throws Exception 下单接口
     */
    public function place($uid, $oProducts) {

        // oProducts和products做对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if(!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        // 开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    // 创建订单
    private function createOrder($snap) {
        // tp5中使用事务，两份数据库同写入或者都不写入
        // 事务开始
        Db::startTrans();

        // 对于有数据库操作的情况，最好做try，catch的处理
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();
            // 事务结束,并提交。Db::startTrans到Db::commit期间的数据库同步写入,保持一致性
            Db::commit();

            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);

            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        }
        catch (Exception $ex) {
            // 事务的执行
            Db::rollback();
            throw $ex;
        }

    }

    // 生成订单编号
    public static function makeOrderNo() {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m')))
            . date('d') . substr(time(), -5) .substr(microtime(), 2, 5)
            . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    // 生成订单快照
    private function snapOrder($status) {
        // status可以单独定义一个类
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => json_encode($this->getUserAddress()),
            'snapName' => $this->products[0]['name'],
            'snapImg' => $this->products[0]['main_img_url']
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];

        if(count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
    }

    // 获取用户地址
    private function getUserAddress() {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }
        return $userAddress->toArray();
    }

    // 根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts) {

//        foreach($oProducts as $oProduct) {
//            // 循环的查询数据库，这种方法不可取
//        }循环的查询数据库
        $oPIDs = [];
        foreach($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        // 直接visible之后是数据集，还需要toArray方法转换成数组，才方便和oProducts做对比
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }

    // 订单信息
    private function getOrderStatus() {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $oProduct) {
            $pSatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pSatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pSatus['totalPrice'];
            $status['totalCount'] += $pSatus['count'];
            array_push($status['pStatusArray'], $pSatus);
        }
        return $status;
    }

    // 数据库产品库存信息
    private function getProductStatus($oPID, $oCount, $products) {
        $pIndex = -1;
        $pStatus = [
          'id' => null,
          'haveStock' => false,
          'count' => 0,
          'name' => '',
          'totalPrice' => 0
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
             //客户端传递的productID有可能根本不存在
            throw new OrderException([
               'msg' => 'id为' . $oPID . '的商品不存在，订单创建失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }
























}