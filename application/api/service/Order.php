<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/19
 * Time: 14:33
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

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
     * @throws Exception
     */
    public function place($uid, $oProducts) {

        // oProducts和products做对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
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
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $oProduct) {
            $pSatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pSatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pSatus['totalPrice'];
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