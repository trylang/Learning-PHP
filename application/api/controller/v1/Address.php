<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/14
 * Time: 16:20
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

class Address extends BaseController
{
    // 前置方法(前置方法必须继承自controller)，在执行某方法之前必须先执行此方法（也相当于是拦截器）
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    protected function checkPrimaryScope() {
        $scope = TokenService::getCurrentTokenVar('scope');
        if($scope) {
            if($scope >= ScopeEnum::User) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

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



















