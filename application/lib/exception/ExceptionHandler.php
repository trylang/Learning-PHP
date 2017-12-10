<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 2017/12/10
 * Time: 18:18
 */

namespace app\lib\exception;


use think\Config;
use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    public function render(Exception $e)
    {
        if($e instanceof BaseException) {
            // 自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else {
//            Config::get('app_debug')
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误，不想告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->code,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e) {
        Log::init([
           'type' => 'File',
           'path' => LOG_PATH,
           'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}