<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Order;
use Livewire\Component;

class CartPage extends Component
{
    public $cart = [];
    public $customerName;
    public $remark;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function increment($itemId)
    {
        if (isset($this->cart[$itemId])) {
            $this->cart[$itemId]['quantity'] += 1;
            session()->put('cart', $this->cart);
        }
    }

    public function decrement($itemId)
    {
        if (isset($this->cart[$itemId])) {
            $this->cart[$itemId]['quantity'] -= 1;

            if ($this->cart[$itemId]['quantity'] <= 0) {
                unset($this->cart[$itemId]);
            }

            session()->put('cart', $this->cart);
        }
    }

    public function remove($itemId)
    {
        if (isset($this->cart[$itemId])) {
            unset($this->cart[$itemId]);
            session()->put('cart', $this->cart);
        }
    }

    public function updateItemRemark($itemId, $remark){
        if(isset($this->cart[$itemId])){
            $this->cart[$itemId]['remark'] = $remark;
            session()->put('cart', $this->cart);
        }
    }

    public function placeOrder()
    {
        // ✅ Validate input
        $this->validate([
            'customerName' => 'required|string|max:255',
        ]);

        if (empty($this->cart)) {
            $this->dispatch('cart-error', ['message' => 'Your cart is empty!']);
            return;
        }

        // ✅ Calculate total
        $totalAmount = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // ✅ Create order
        $order = Order::create([
            'customer_name' => $this->customerName,
            'remarks' => $this->remark,
            'total_amount' => $totalAmount,
            'status' => 0,
        ]);

        // Save booking items
        foreach ($this->cart as $item) {
            Booking::create([
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'order_id' => $order->id,
                'remark'=>$item['remark'] ?? null,
            ]);
        }

        // Clear everything
        $this->cart = [];
        $this->customerName = '';
        $this->remark = '';
        session()->forget('cart');

        $this->dispatch('order-placed', ['message' => 'Order placed successfully!']);

        //redirect to order progress page
        return redirect()->route('guest.order',['orderId'=>$order->id]);
    }

    public function render()
    {
        return view('livewire.cart-page')
            ->layout('layouts.guest');
    }
}
