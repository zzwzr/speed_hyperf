<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BaseException;
use App\Logger\OrderLogger;
use App\Model\Good;
use App\Model\Order;
use App\Model\OrderItem;
use App\Request\Order\CreateRequest;
use App\Resource\Common\BaseResource;
use App\Service\OrderQueueService;
use Hyperf\Di\Annotation\Inject;

class OrderController
{
    #[Inject]
    protected OrderQueueService $service;

    public function create(CreateRequest $request)
    {
        $validated = $request->validated();
        try {
            $insertAll = [];
            $totalAmount = 0;
            foreach ($validated['goods'] as $k => $v) {
                $good = Good::where('id', $v['id'])->first();

                $itemTotalAmount = round($good->price * $v['quantity'], 2);

                $totalAmount += $itemTotalAmount;
                $insertAll[] = [
                    // 'order_id' => ,
                    'category_id'   => $good->category_id,
                    'brand_id'      => $good->brand_id,
                    'goods_id'      => $v['id'],
                    'goods_name'    => $good->name,
                    'goods_price'   => $good->price,
                    'quantity'      => $v['quantity'],
                    'total_amount'  => $itemTotalAmount
                ];
            }
            $user = json_decode(strval(\Hyperf\Context\Context::get('user')), true);


            $create = [
                'order_no'          => bin2hex(random_bytes(16)),
                'user_id'           => $user['id'],
                'total_amount'      => round($totalAmount, 2),
                'status'            => 1,
                'payment_status'    => 1,
                'address_id'        => $validated['address_id'],
                'address_json'      => ['id' => 1, 'mobile' => 110, 'address' => '啊啊啊']
            ];

            $this->service->push(['order' => $create, 'iteams' => $insertAll]);

            return new BaseResource();

        } catch (\Throwable $th) {
            OrderLogger::error($th->getMessage());
            throw new BaseException('订单创建失败');
        }
    }

    /**
     * 队列订单插入
     * @param [type] $params
     * @return void
     */
    public static function createRun($params): void
    {
        $order = Order::create($params['order']);
        foreach ($params['iteams'] as $k => $v) {
            $params['iteams'][$k]['order_id'] = $order->id;
        }
        OrderItem::insert($params['iteams']);
    }
}
