<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Shoppinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShoppinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $shoppinglists = $user->shoppinglists()->orderBy('id', 'ASC')->paginate(5);
        $products = Product::all();
        return view('shoppinglist.index')->with('shoppinglists', $shoppinglists)->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('Shoppinglist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        /*dd($request);*/
        $request->validate(Shoppinglist::$rules);
        $shoppinglist = new Shoppinglist([
            'name' => $request['name'],
            'note' => $request['note'],
            'user_id' => auth()->id()
        ]);
        $shoppinglist->save();
        return redirect('/shoppinglist')->with([
            'meldung_success' => 'Die Liste ' . $shoppinglist->name . ' wurde angelegt'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shoppinglist $shoppinglist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Shoppinglist $shoppinglist, Product $product)
    {
        $products = $shoppinglist->products()->orderBy('product_shoppinglist.sort', 'ASC')->get();
        return view('shoppinglist.show')->with('shoppinglist', $shoppinglist)->with('products', $products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shoppinglist $shoppinglist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Shoppinglist $shoppinglist)
    {
        $products = $shoppinglist->products()->orderBy('product_shoppinglist.sort', 'ASC')->get();
        return view('shoppinglist.edit')->with('shoppinglist', $shoppinglist)->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shoppinglist $shoppinglist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function update(Request $request, Shoppinglist $shoppinglist)
    {
        $request->validate(Shoppinglist::$rules);

        $shoppinglist->update([
            'name' => $request->name,
            'note' => $request->note
        ]);

        if($request->get('delete_image', false)) {
            $shoppinglist->clearMediaCollection('images');
        }

        if ($request->hasFile('image')) {
            $shoppinglist->clearMediaCollection('images');
            $shoppinglist->addMedia($request->file('image'))->toMediaCollection('images');
        }
        return redirect('shoppinglist')->with('shoppinglist', $shoppinglist)->with([
            'meldung_success' => 'Die Liste ' . $shoppinglist->name . ' wurde editiert'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shoppinglist $shoppinglist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Shoppinglist $shoppinglist)
    {
        foreach ($shoppinglist->products as $product) {
            $product->delete();
        }
        $shoppinglist->products()->detach();
        $shoppinglist->delete();
        return redirect('/shoppinglist')->with([
            'meldung_success' => 'Die Liste wurde gelöscht'
        ]);
    }

    public function recipes()
    {
        $shoppinglists = Shoppinglist::where('public', '=', 1)->orderBy('id', 'ASC')->paginate(5);
        return view('shoppinglist.recipes')->with('shoppinglists', $shoppinglists);
    }

    public function updateOrder(Request $request, Shoppinglist $shoppinglist)
    {
        $order = $request->input('order');
        foreach ($order as $key => $value) {
            $shoppinglist->products()->updateExistingPivot($value, ['sort' => $key]);
            Log::debug(print_r($request->all(), true));
        }
        return "success";
    }

    public function ajaxDeleteProduct(Request $request)
    {
        $product_id = $request->input('product_id');
        $shoppinglist_id = $request->input('shoppinglist_id');
        $shoppinglist = Shoppinglist::find($shoppinglist_id);
        $shoppinglist->products()->detach([$product_id]);
        return response()->json([
            'message' => 'Produkt erfolgreich gelöscht'
        ]);
    }
    public function ajaxDeleteShoppinglist(Request $request, Shoppinglist $shoppinglist)
    {
        $shoppinglist_id = $request->input('shoppinglist_id');
        $shoppinglist = Shoppinglist::find($shoppinglist_id);
        foreach ($shoppinglist->products as $product) {
            $product->delete();
        }
        $shoppinglist->delete();
        return response()->json([
            'success' => 'Shoppinglist successfully deleted',
            'error' => 'Nönö!',
            'shoppinglist_id' => $shoppinglist_id
        ]);
    }

    public function ajaxAddRecipe(Shoppinglist $shoppinglist)
    {
        $productNewIds = array();                           //legt neues Array an  für neue Shoppinglist IDs
        $shoppinglistNew = $shoppinglist->replicate();      //repliziert vorhandene Shoppinglist in neuer Shoppinglist
        $shoppinglistNew->user_id = Auth::user()->id;       //weist neuer SHoppinglist ID des eingeloggten Users zu
        $shoppinglistNew->push();                           //speichert kopierte Shoppinglist mit ihren Beziehungen
        foreach ($shoppinglist->products as $product) {
            $productNew = $product->replicate();            //repliziert vorhandenes Produkt in neuer Shoppinglist
            $productNew->push();                            //speichert Produkt in neuer Shoppinglist
            $productNewIds[] = $productNew->id;             //speichert die IDs aller neuen Produkte in Array
        }
        $shoppinglistNew->products()->sync($productNewIds); //verbindet neue Produkte mit neuer Shoppinglist
        return response()->json([
            'success' => 'Rezept hinzugefügt. Das macht dir so schnell keiner nach!',
            'error' => 'Da ist wohl etwas schiefgegangen. Versuch es doch nächste Woche noch einmal -\o/-'
        ]);
    }
}
