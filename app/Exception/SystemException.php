<?php
namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class SystemException extends ServerException
{
    protected $code = 500;
    protected $message = '未定义的错误';

    /**
     * constructor
     * @param string|null $message 错误信息
     * @param int|null $code 错误码
     * @param array $errorData 错误详情
     */
    public function __construct(string $message = null, int $code = null, array $errorData = [])
    {
        $this->message = $message ?: $this->message;
        $this->code = $code ?: $this->code;
        
        parent::__construct($this->message, $this->code);
    }
}
