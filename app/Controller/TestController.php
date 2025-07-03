<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BaseException;
use App\Logger\UserLogger;
use App\Model\User;
use App\Request\Login\RegisterRequest;
use App\Resource\Common\BaseResource;
use App\Resource\Login\RegisterResource;
use App\Resource\User\IndexCollection;
use App\Resource\User\IndexResource;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
// use Casbin\Enforcer;
use Donjan\Casbin\Enforcer;
use Hyperf\Context\ApplicationContext;

class TestController
{
    // public function test(RegisterRequest $request)
    public function test(RequestInterface $request)
    {
        $uuid = $request->input('uuid');

        if ($uuid) {
            $container = ApplicationContext::getContainer();

            $redis = $container->get(\Hyperf\Redis\Redis::class);

            if ($redis->setnx($uuid, 'vv')) {
                // echo "设置成功！\n";
            } else {
                // echo "键已存在！\n";
            }
        }
        // echo "缺少键！\n";

        // return new BaseResource();
        // try {

            // 添加权限
            // Enforcer::addPermissionForUser('4', '/user', 'read');
            // return new BaseResource(['a1' => 'aaa', 'a2' => 222, 'a3' => 333]);

            // $list = User::paginate();

            // return (new IndexCollection($list))->toResponse();

            // 分页返回
            // return IndexResource::collection($list)->additional(resourceWith())->toResponse();
        // } catch (\Throwable $th) {
        //     // UserLogger::error($th->getMessage());
        //     throw new BaseException($th->getMessage());
        // }
    }
}
