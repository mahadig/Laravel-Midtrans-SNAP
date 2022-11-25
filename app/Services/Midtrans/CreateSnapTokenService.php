<?php

namespace App\Services\Midtrans;

use Midtrans\Config;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
	protected $order;

	public function __construct($order)
	{
		parent::__construct();

		$this->order = $order;
	}

	public function getSnapToken()
	{
        $items = [];

        foreach ($this->order['items'] as $item) {
            $items[] = [
                'id'       => $item['id'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'name'     => $item['name']
            ];
        }

		$transaction_data = [
            "transaction_details" => [
                "order_id" => $this->order['id'],
                "gross_amount" => $this->order['gross_amount']
            ],
            "item_details" => $items,
        ];

		$snapToken = Snap::getSnapToken($transaction_data);

		return $snapToken;
	}
}
