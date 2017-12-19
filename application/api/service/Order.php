<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/19
 * Time: 14:33
 */

namespace app\api\service;


use app\api\model\Product;

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


























}