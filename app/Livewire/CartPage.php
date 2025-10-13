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

    public function increment($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity'] += 1;
            session()->put('cart', $this->cart);
        }
    }

    public function decrement($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity'] -= 1;

            if ($this->cart[$menuId]['quantity'] <= 0) {
                unset($this->cart[$menuId]);
            }

            session()->put('cart', $this->cart);
        }
    }

    public function remove($menuId)
    {
        if (isset($this->cart[$menuId])) {
            unset($this->cart[$menuId]);
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

        // ✅ Save booking items
        foreach ($this->cart as $item) {
            Booking::create([
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'order_id' => $order->id,
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
