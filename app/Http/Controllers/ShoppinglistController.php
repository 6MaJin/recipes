<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shoppinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ShoppinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoppinglists = Shoppinglist::orderBy('id', 'ASC')->paginate(5);
        return view('shoppinglist.index')->with('shoppinglists', $shoppinglists);
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
        return view('shoppinglist.edit')->with('shoppinglist', $shoppinglist)->with([
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
        $shoppinglist->delete();
        return redirect('/shoppinglist')->with([
            'meldung_success' => 'Die Liste wurde gelöscht'
        ]);
        /* return $this->index()->with([
             'meldung_success' => 'Die Liste wurde gelöscht'
         ]);*/
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

    public function ajaxSetPublic() {

    }
}
