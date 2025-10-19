<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class MenuQuickToggle extends Component
{
    public $menusByCategory = [];

    public function mount()
    {
        $this->loadMenus();
    }

    public function loadMenus()
    {
        // Fetch and group menus by category, then convert to plain array
        $menus = Menu::orderBy('category')->get();

        $grouped = $menus->groupBy('category');

        // Convert grouped collection into an array of arrays
        $this->menusByCategory = $grouped->map(function ($group) {
            return $group->toArray();
        })->toArray();
    }

    public function toggleStatus($menuId)
    {
        $menu = Menu::find($menuId);

        if ($menu) {
            $menu->avail_status = !$menu->avail_status;
            $menu->save();
            $this->loadMenus(); // Refresh
        }
    }

    public function render()
    {
        return view('livewire.menu-quick-toggle');
    }
}
