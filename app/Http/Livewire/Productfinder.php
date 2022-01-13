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
        $user = Auth::user();

        if (strlen($this->search) > 1) {
            $products = DB::table('products')
                ->join('product_shoppinglist', 'products.id', '=', 'product_shoppinglist.product_id')
                ->join('shoppinglists', 'shoppinglists.id', '=', 'product_shoppinglist.shoppinglist_id')
                ->join('users', 'users.id', '=', 'shoppinglists.user_id')
                ->where('users.id', '=', $user->id)
                ->where('products.name', 'LIKE', '%' . $this->search . '%')
                ->select('products.name')
                ->exists()
                ->get();
            $products = Product::whereHas('shoppinglists', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })
            ->where('products.name', 'LIKE', '%' . $this->search . '%')
            ->get();
        } else {
            $products = array();
        }

        return view('livewire.productfinder', [
            'products' => $products,
        ]);
    }
}
