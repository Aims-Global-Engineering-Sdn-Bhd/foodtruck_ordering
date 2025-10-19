<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderDetailModal extends Component
{
    public $order;
    public $items = [];

    protected $listeners = ['loadOrderDetail' => 'loadOrder'];

    public function loadOrder($orderId)
    {
        $this->order = Order::with('bookings.menu')->find($orderId);

        if ($this->order) {
            $this->items = $this->order->bookings->map(function ($b) {
                return [
                    'menu_name' => $b->menu->name,
                    'quantity' => $b->quantity,
                    'price' => $b->menu->price,
                    'remark'=> $b->remark,
                ];
            })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.order-detail-modal');
    }
}
