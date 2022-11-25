<?php

namespace App\Http\Controllers;

use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    protected $items = [
        [
            "id"    => "item_1",
            "name"  => "Item 1",
            "price" => 15000
        ],
        [
            "id"    => "item_2",
            "name"  => "Item 2",
            "price" => 25000
        ]
    ];

    public function order(){
        return view('order')
            ->with('items', $this->items);
    }

    public function pay(Request $request){
        $request->validate([
            'products' => ['required','array',"min:1"]
        ]);

        $order['id'] = time();
        $order['gross_amount'] = 0;
        
        foreach ($request->products as $value) {
            $item = Arr::first($this->items, function($row) use ($value){
                return $row['id'] = $value;
            });

            /** Sample quantity */
            $item['quantity'] = 1;

            $order['gross_amount'] = $item['quantity'] * $item['price'];

            $order['items'][] = $item;
        }

        $order['snap_token'] = (new CreateSnapTokenService($order))->getSnapToken();

        return view('pay')
            ->with('order', $order);
    }
}
