<?php

namespace App\Resource\Common;

use Hyperf\Resource\Json\JsonResource;

class BaseResource extends JsonResource
{
    use \App\Traits\ResourceTrait;

    protected $code;
    protected $message;

    public function __construct($resource = [], $code = 200, $message = 'success')
    {
        parent::__construct($resource);
        $this->code = $code;
        $this->message  = $message;
    }
}
