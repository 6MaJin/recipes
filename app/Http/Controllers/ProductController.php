<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use App\Models\Shoppinglist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate(Product::$rules);
        $product = new Product([
            'name' => $request['name'],
            'note' => "Notiz"
        ]);
        $product->save();
        return redirect('/recipe')->with('recipe', $recipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product, Shoppinglist $shoppinglist)
    {
        $product->delete();

        return redirect('/shoppinglist')->with([
            'meldung_success' => 'Die Liste wurde gelöscht']
        );
    }


    public function ajaxStore(Request $request)
    {
        $request->validate(Product::$rules);
        $product = new Product([
            'name' => $request['name'],
            'note' => "Notiz"
        ]);
        $product->save();
        $shoppinglist = Shoppinglist::find($request['shoppinglist_id']);
        $shoppinglist->products()->save($product);
        return json_encode(
            [
                'status' => 'success',
                'product_id' => $product->id,
                'shoppinglist_id' => $shoppinglist->id,
                'product_name' => $product->name
            ]
        );
    }

    public function ajaxStoreRecipe(Request $request)
    {
        $request->validate(Product::$rules);
        $product = new Product([
            'name' => $request['name'],
            'note' => "Notiz"
        ]);
        $product->save();
        $recipe = Recipe::find($request['recipe_id']);
        $recipe->products()->save($product);
        return json_encode(
            [
                'status' => 'success',
                'product_id' => $product->id,
                'recipe_id' => $recipe->id,
                'product_name' => $product->name
            ]
        );
    }
    public function ajaxDelete($id) {
        $this->destroy($id);
        return \response()->json([
            'success' => 'Product successfully deleted from Shoppinglist'
        ]);
    }

}
