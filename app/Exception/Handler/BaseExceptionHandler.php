<?php

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use App\Exception\BaseException;
use App\Logger\UserLogger;
use Hyperf\Context\Context;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * 用于处理代码中异常
 */
class BaseExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof BaseException) {

            $this->stopPropagation();
            $request = Context::get(ServerRequestInterface::class);

            $status = $throwable->getCode();
            $message = $throwable->getMessage();

            $data = json_encode(['code' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE);
            return $response->withStatus(200)
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
