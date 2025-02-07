<?php

declare(strict_types=1);

namespace App\Tools;

class ExceptionConstantTool
{
    const ERROR_USER_NOT_FOUND = 10001;
    const ERROR_PASSWORD_INCORRECT = 10002;

    const ERROR_MESSAGES = [
        self::ERROR_USER_NOT_FOUND => '用户不存在',
        self::ERROR_PASSWORD_INCORRECT => '密码错误',
    ];
}