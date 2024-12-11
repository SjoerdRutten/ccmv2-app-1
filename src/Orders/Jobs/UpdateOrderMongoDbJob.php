<?php

namespace Sellvation\CCMV2\Orders\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Orders\Models\Order;
use Sellvation\CCMV2\Orders\Models\OrderMongo;

class UpdateOrderMongoDbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Order $order)
    {
        $this->queue = 'scout';
    }

    public function handle(): void
    {
        if ($this->order->order_time->isAfter(now()->subYear())) {
            $data = [
                'id' => $this->order->id,
                'order_type_id' => (int) $this->order->order_type_id,
                'crm_card_id' => $this->order->crm_card_id,
                'order_number' => $this->order->order_number,
                'loyalty_card' => $this->order->loyalty_card,
                'payment_method' => $this->order->payment_method,
                'store' => (int) $this->order->store,
                'order_time' => $this->order->order_time->toIso8601String(),
                'total_price' => (int) $this->order->total_price,
                'number_of_products' => (int) $this->order->number_of_products,
            ];

            foreach (\CustomOrderFields::getSchemaFields('orders') as $field) {
                $fieldName = $field['name'];
                $value = $this->order->$fieldName;

                switch ($field['type']) {
                    case 'bool':
                        $value = (bool) $value;
                        break;
                    case 'string':
                        $value = (string) $value;
                        break;
                    default:
                        $value = (int) $value;
                }

                $data[$fieldName] = $value;
            }

            $data['order_rows'] = [];
            foreach ($this->order->orderRows as $orderRow) {
                $data['order_rows'][] = [
                    'id' => $orderRow->id,
                    'order_id' => (int) $orderRow->order_id,
                    'product_id' => (int) $orderRow->product_id,
                    'amount' => (int) $orderRow->amount,
                    'unit_price' => (int) $orderRow->unit_price,
                    'total_price' => (int) $orderRow->total_price,
                    'is_promo' => (int) $orderRow->is_promo,
                    'sku' => (string) $orderRow->product->sku,
                    'eans' => $orderRow->product->eans->pluck('ean')->toArray(),
                ];
            }

            \Context::add('environment_id', $this->order->environment_id);
            if ($orderMongo = OrderMongo::where('id', $this->order->id)->first()) {
                $orderMongo->update($data);
            } else {
                OrderMongo::create($data);
            }
        }
    }
}
