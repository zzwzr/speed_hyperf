<?php

declare(strict_types=1);

/**
 * 资源类返回额外参数
 * @param integer $code
 * @param string $message
 * @return array
 */
function resourceWith(int $code = 200, string $message = 'success'): array
{
    return [
        'code'  => $code,
        'message'   => $message
    ];
}
