<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderReceiver extends Component
{
    public $newOrders = [];
    public $inProgressOrders = [];
    protected $listeners = [
        'orderUpdated' => 'checkForNewOrders',
        'cancelOrder' => 'cancelOrder'
    ];

    public $lastOrderCount = 0; // track previously known new orders

    public function mount()
    {
        $this->loadOrders();
        $this->lastOrderCount = Order::where('status', 0)->count();
    }

    public function loadOrders()
    {
        $this->newOrders = Order::where('status', 0)->latest()->get();
        $this->inProgressOrders = Order::where('status', 1)->latest()->get();
    }

    public function checkForNewOrders()
    {
        $currentCount = Order::where('status', 0)->count();

        // Trigger alert only when new order appears
        if ($currentCount > $this->lastOrderCount) {
            $this->dispatch('new-order');
        }

        $this->lastOrderCount = $currentCount;
        $this->loadOrders();
    }

    public function cancelOrder($orderId){
        $order = Order::find($orderId);

        if($order){
            $order->status = 4;
            $order->save();

            $this->dispatch('swal:success', [
                'title' => 'Payment Completed!',
                'text' => 'Order moved to In Progress.',
            ]);

            $this->loadOrders();
        }
    }

    public function completePayment($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = 1;
            $order->save();

            $this->dispatch('swal:success', [
                'title' => 'Payment Completed!',
                'text' => 'Order moved to In Progress.',
            ]);

            $this->loadOrders();
        }
    }

    public function markAsReady($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = 2;
            $order->save();

            $this->dispatch('swal:success', [
                'title' => 'Order Ready!',
                'text' => 'Order marked as ready to pickup.',
            ]);

            $this->loadOrders();
        }
    }

    public function render()
    {
        return view('livewire.order-receiver');
    }
}
