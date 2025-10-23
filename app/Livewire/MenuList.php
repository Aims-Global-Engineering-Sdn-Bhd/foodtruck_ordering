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

    public $showRemarkModal = false;
    public $showDrinkModal = false;

    public $selectedMenu = null;
    public $remark = '';
    public $selectedDrink = '';

    public $softDrinks = [];

    public function mount()
    {
        // Load menus and categories
        $this->loadMenus();
        $this->categories = Menu::select('category')->distinct()->pluck('category');
        $this->softDrinks = Menu::where('category', 'SOFT DRINKS')
            ->where('avail_status', 1)
            ->get();
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

        // Category : MASAKAN PANAS -> optional remark
        if($menu->category==='MASAKAN PANAS'){
            $this->selectedMenu = $menu;
            $this->remark = '';
            $this->showRemarkModal = true;
            return;
        }

        //RTE SET COMBO -> include a soft drink
        if($menu->category==='RTE SET COMBO + SOFT DRINKS (16 OZ)'){
            $this->selectedMenu = $menu;
            $this->selectedDrink = '';
            $this->showDrinkModal = true;
            return;
        }

        $this->addMenuToCart($menu);
    }

    public function confirmAddRemark()
    {
        $menu = $this->selectedMenu;
        if (!$menu) return;

        $this->addMenuToCart($menu, $this->remark);
        $this->showRemarkModal = false;
    }

    public function confirmSelectDrink()
    {
        $menu = $this->selectedMenu;
        if (!$menu || !$this->selectedDrink) return;

        $remark = "Selected drink: " . $this->selectedDrink;
        $this->addMenuToCart($menu, $remark);
        $this->showDrinkModal = false;
    }

    private function addMenuToCart($menu, $remark = null){
        // Load current cart from session
        $cart = session()->get('cart', []);

        $cartKey = $menu->id.'-'.md5($remark ?? '');

        if (!isset($cart[$cartKey])) {
            $cart[$cartKey] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'remark' => $remark
            ];
        } else {
            // If same remark already exists, just increment quantity
            $cart[$cartKey]['quantity']++;
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
            'groupedMenus' => $groupedMenus,
            'softDrinks'=>$this->softDrinks,
        ]);
    }
}
