<?php
namespace App\Exception;

use App\Tools\ExceptionConstantTool;
use Hyperf\Server\Exception\ServerException;

class BaseException extends ServerException
{
    protected $code = 10000;
    protected $message = '未定义的错误';

    /**
     * constructor
     * @param $message 错误信息
     * @param int|null $code 错误码
     * @param array $errorData 错误详情
     */
    public function __construct($message = null, int $code = null, \Throwable $previous = null)
    {
        // 如果 message 传整数，到 ExceptionConstantTool 写 ERROR_MESSAGES

        $this->code = is_int($message) ? $message : ($code ?: $this->code);

        $this->message = is_int($message) ? (ExceptionConstantTool::ERROR_MESSAGES[$message] ?? $this->message) : ($message ?: $this->message);

        parent::__construct($this->message, $this->code, $previous);
    }
}
