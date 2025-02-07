<?php

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use App\Exception\SystemException;
use Hyperf\Context\Context;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * 用于处理系统代码异常
 */
class SystemExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof SystemException) {

            $status = $throwable->getCode();
            $message = $throwable->getMessage();
            // $status = 500;
            // $message = '系统错误';
            $this->stopPropagation();
            $data = json_encode(['code' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE);

            $request = Context::get(ServerRequestInterface::class);
            return $response->withStatus($status)
                            ->withHeader('Content-type', 'application/json; charset=utf-8')
                            ->withHeader('Access-Control-Allow-Origin', $request->getHeaderLine('origin'))
                            ->withHeader('Access-Control-Allow-Credentials', 'true')
                            ->withHeader('Access-Control-Allow-Headers', 'Keep-Alive, User-Agent, Cache-Control, Content-Type, Authorization')
                            ->withBody(new SwooleStream($data));
        }

        return $response;
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
