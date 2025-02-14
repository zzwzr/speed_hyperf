<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;

#[Process(name: 'OrderConsumerProcess')]
class OrderConsumerProcess extends AbstractProcess
{
    protected string $queue = 'order';

    public function handle(): void
    {
    }
}
