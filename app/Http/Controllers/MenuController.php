<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Function to retrieve all
    public function index()
    {
        $menus = Menu::all();

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            "ALA CARTE (STANDARD)",
            "ALA CARTE (SIGNATURE)",
            "RTE SET COMBO + SOFT DRINKS (16 OZ)",
            "MASAKAN PANAS",
            "ALA CARTE LOKCING",
            "ALA CARTE WESTERN (SIDE DISH)",
            "BEVERAGE",
            "DRINKS (SOFT DRINKS)"
        ];


        return view('menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'avail_status' => 'required|boolean',
            'category' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'url_food'=>'nullable|image|mimes:jpeg,jpg,png,gif|max:4096'
        ]);

        if ($request->hasFile('url_food')){
            $file = $request->file('url_food');
            $filename = date('Ymd_His') . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $destination = public_path('uploads/menus');

            // Create directory if not exist
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            $file->move($destination, $filename);

            // Save path to validated array
            $validated['url_food'] = 'uploads/menus/' . $filename;
        }

        Menu::create($validated);

        return redirect()->route('menu.index')->with('success', 'Menu created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'avail_status' => 'required|boolean',
            'category' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'url_food'=>'nullable|image|mimes:jpeg,jpg,png,gif|max:4096'
        ]);

        if ($request->hasFile('url_food')) {
            $file = $request->file('url_food');
            $filename = date('Ymd_His') . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $destination = public_path('uploads/menus');

            // Create directory if not exist
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            // Delete old image if exists
            if ($menu->url_food && file_exists(public_path($menu->url_food))) {
                unlink(public_path($menu->url_food));
            }

            // Move new file
            $file->move($destination, $filename);

            // Save new path
            $validated['url_food'] = 'uploads/menus/' . $filename;
        } else {
            // Keep old image if no new upload
            $validated['url_food'] = $menu->url_food;
        }

        // 🟩 Update the record
        $menu->update($validated);

        return redirect()->route('menu.show', $menu)
            ->with('success', 'Menu updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menu.index')->with('success','Menu deleted successfully');
    }
}
