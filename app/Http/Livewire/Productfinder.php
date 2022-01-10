<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Shoppinglist;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use PhpParser\ErrorHandler\Collecting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Productfinder extends Component
{
    public $search;
    public $shoppinglist;

    public function render()
    {
        if(strlen($this->search)>1) {
            $user = Auth::user();
            /*$products = Product::where('name', 'LIKE', '%' . $this->search . '%')->get();*/

            /*$products = Product::where('name', 'LIKE', '%' . $this->search . '%')
                ->where('products.id', '=', 'product_shoppinglist.product_id')
                ->get();*/
            $products = DB::table('users')
                ->join('shoppinglists', 'users.id', '=', 'shoppinglists.user_id')
                ->join('product_shoppinglist', 'shoppinglists.id', '=', 'product_shoppinglist.shoppinglist_id')
                ->join('products', 'products.id', '=', 'product_shoppinglist.product_id')
                ->where('users.id', '=', $user->id)
                ->where('products.name', 'LIKE', '%' . $this->search . '%')
                ->get();
        } else {
            $products = Array();
        }
        return view('livewire.productfinder', [
                'products' => $products,
        ]);
    }
}
