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

class TestController
{
    public function test(RegisterRequest $request)
    {
        $validated = $request->validated();
        // try {
            
            // 添加权限
            // Enforcer::addPermissionForUser('4', '/user', 'read');
            // return new BaseResource(['a1' => 'aaa', 'a2' => 222, 'a3' => 333]);

            $list = User::paginate();

            // return (new IndexCollection($list))->toResponse();

            // 分页返回
            return IndexResource::collection($list)->additional(resourceWith())->toResponse();
        // } catch (\Throwable $th) {
        //     // UserLogger::error($th->getMessage());
        //     throw new BaseException($th->getMessage());
        // }
    }
}
