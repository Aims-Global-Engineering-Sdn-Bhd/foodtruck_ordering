<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class MenuList extends Component
{
    public $menus;
    public $categories;
    public $selectedCategory = null;

    public $cart = [];       // in-memory cart
    public $cartCount = 0;   // total unique items in cart

    public function mount()
    {
        // Load menus and categories
        $this->menus = Menu::all();
        $this->categories = Menu::select('category')->distinct()->pluck('category');
    }

    public function loadMenus(){
        $query = Menu::query();

        if($this->selectedCategory){
            $query->where('category', $this->selectedCategory);
        }

        $this->menus = $query->orderBy('category')->get();
        $this->categories = Menu::select('category')->distinct()->pluck('category');
        $this->cartCount = count(session()->get('cart', []));
    }

    public function refreshMenus(){
        $this->loadMenus();
    }

    public function filterCategory($category)
    {
        $this->selectedCategory = $category;
        $this->loadMenus();
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) return;

        // Load current cart from session
        $cart = session()->get('cart', []);

        if (!isset($cart[$menuId])) {
            $cart[$menuId] = [
                'id' => $menuId,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1
            ];
        } else {
            $cart[$menuId]['quantity']++;
        }

        session()->put('cart', $cart);

        $this->cartCount = count($cart);

        $this->dispatch('cart-added', ['message' => 'Success! Item added to cart.']);
    }


    public function render()
    {
        // Group menus by category for display
        $groupedMenus = $this->menus->groupBy('category');

        return view('livewire.menu-list', [
            'groupedMenus' => $groupedMenus
        ]);
    }
}
