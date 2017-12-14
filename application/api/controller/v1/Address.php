<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/14
 * Time: 16:20
 */

namespace app\api\controller\v1;

use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    public function createOrUpdateAddress() {
        $validata = new AddressNew();
        $validata->goCheck();
        // 根据Token获取UID
        // 根据UID查找用户数据，判断用户是否存在，如果不存在就抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在，判断是添加还是更新地址
        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }

        // 获取前台传入的地址参数
        $dataArray = $validata->getDataByRule(input('post.'));

        $userAddress = $user->address;
        if(!$userAddress) {
            // 没有用户地址，就新增一个，这里的新增没有使用create，还是使用的关联新增
            $user->address()->save($dataArray);
        }else {
            // 更新地址
            $user->address->save($dataArray);
        }
        // return $user;
        return json(new SuccessMessage(), 201);
    }
}



















