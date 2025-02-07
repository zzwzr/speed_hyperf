<?php

declare(strict_types=1);

namespace App\Traits;

trait ResourceTrait
{
    public function with(): array
    {
        return resourceWith($this->code, $this->message);
    }
}
