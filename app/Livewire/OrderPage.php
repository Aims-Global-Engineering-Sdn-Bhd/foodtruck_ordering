<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Order;
use Livewire\Component;

class OrderPage extends Component
{
    public $orderId;
    public $order;
    public $bookings;
    public $progress = 0;

    protected $listeners = [
        'refreshStatus' => 'loadOrder',
        'cancelOrder' => 'cancelOrder'
    ];

    public function mount($orderId){
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder(){
        $this->order = Order::find($this->orderId);
        $this->bookings = Booking::where('order_id', $this->orderId)
                            ->with('menu')
                            ->get();

        // Update progress bar
        switch ($this->order->status) {
            case 0: $this->progress = 20; break; // New order
            case 1: $this->progress = 50; break; // Preparing
            case 2: $this->progress = 80; break; // Ready
            case 3: $this->progress = 100; break; // Completed
            case 4: $this->progress = 100; break; // Cancelled
            default: $this->progress = 0;
        }
    }

    public function cancelOrder(){
        $this->order->update([
            'status'=>4,
        ]);

        $this->loadOrder();

        $this->dispatch('order-updated',['message'=>'Your order is cancelled!']);
    }

    public function completeOrder(){
        $this->order->update([
            'status'=>3,
            'pickup_time'=>now()
        ]);

        $this->loadOrder();

        $this->dispatch('order-updated', ['message' => 'Order marked as picked up successfully!']);
    }

    public function render()
    {
        return view('livewire.order-page')->layout('layouts.guest');
    }
}
