<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;
use PhpParser\ErrorHandler\Collecting;

class Productfinder extends Component
{
    public $search;
    public $shoppinglist;

    public function render()
    {
        if(strlen($this->search)>1) {
            $products = Product::where('name', 'LIKE', '%' . $this->search . '%')->get();
        } else {
            $products = Array();
        }
        return view('livewire.productfinder', [
                'products' => $products,
        ]);
    }
}
