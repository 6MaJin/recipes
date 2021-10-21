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
        $admins = User::where('is_admin', '=', '1')->get();
        $shoppinglists = Auth::user()->shoppinglists()->paginate(5);;
/*        $shoppinglists = Shoppinglist::orderBy('id', 'ASC')->paginate(5);*/
        return view('shoppinglist.index')->with('shoppinglists', $shoppinglists)->with('admins', $admins);
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
        return view('shoppinglist.show')->with('shoppinglist', $shoppinglist)->with('product', $product);
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
            $productIds[] = $product->id;
            $product->delete();
        }
        $shoppinglist->products()->detach();
        $shoppinglist->delete();
        return redirect('/shoppinglist')->with([
            'meldung_success' => 'Die Liste wurde gelöscht'
        ]);
        /* return $this->index()->with([
             'meldung_success' => 'Die Liste wurde gelöscht'
         ]);*/
    }

    public function recipes(Shoppinglist $shoppinglist)
    {
        $shoppinglists = Shoppinglist::orderBy('id', 'ASC')->paginate(5);;
        return view('shoppinglist.recipes')->with('shoppinglist', $shoppinglist)->with('shoppinglists', $shoppinglists);
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

    public function ajaxDelete(Request $request)
    {
        $product_id = $request->input('product_id');
        $shoppinglist_id = $request->input('shoppinglist_id');
        $shoppinglist = Shoppinglist::find($shoppinglist_id);
        $shoppinglist->products()->detach([$product_id]);
        return response()->json([
            'success' => 'Product successfully deleted from Shoppinglist'
        ]);
    }
    public function ajaxDeleteShoppinglist(Request $request, Shoppinglist $shoppinglist)
    {

        $shoppinglist::find($shoppinglist->id)->delete($shoppinglist->id);
        /*$shoppinglist->products()->detach([$product_id]);*/
        return response()->json([
            'success' => 'Shoppinglist successfully deleted'
        ]);
    }

    public function ajaxSetPublic(Request $request)
    {
        $shoppinglist_id = $request->input('shoppinglist_id');
        $public = $request->input('public');
        $shoppinglist = Shoppinglist::find($shoppinglist_id);
        $shoppinglist->public = $public;
        $shoppinglist->save();
    }

    public function ajaxAddRecipe(Shoppinglist $shoppinglist)
    {
        $productNewIds = array();
        $shoppinglistNew = $shoppinglist->replicate();
        $shoppinglistNew->user_id = Auth::user()->id;
        $shoppinglistNew->push();
        foreach ($shoppinglist->products as $product) {
            $productNew = $product->replicate();
            $productNew->push();
            $productNewIds[] = $productNew->id;
        }
        $shoppinglistNew->products()->sync($productNewIds);
        return response()->json([
            'success' => 'Rezept hinzugefügt. Das macht dir so schnell keiner nach!',
            'error' => 'Da ist wohl etwas schiefgegangen. Versuch es doch nächste Woche noch einmal -\o/-'
        ]);
    }
}
