<?php

namespace App\Http\Controllers;

use App\Models\Shoppinglist;
use Illuminate\Http\Request;

class ShoppinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoppinglists = Shoppinglist::paginate(5);
        /*$shoppinglists = Shoppinglist::all();*/
        return view('shoppinglist.index')->with('shoppinglists', $shoppinglists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('Shoppinglist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*dd($request);*/
        $request->validate([
            'name' => 'required|min:2'
        ]);
        $shoppinglist = new Shoppinglist([
            'name' => $request['name'],
            'note' => $request['note']
        ]);
        $shoppinglist->save();
        /*return redirect('/shoppinglist');*/
        return $this->index()->with([
            'meldung_success' => 'Die Liste '.$shoppinglist->name.' wurde angelegt'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shoppinglist  $shoppinglist
     * @return \Illuminate\Http\Response
     */
    public function show(Shoppinglist $shoppinglist)
    {
        return view('shoppinglist.show')->with('shoppinglist', $shoppinglist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shoppinglist  $shoppinglist
     * @return \Illuminate\Http\Response
     */
    public function edit(Shoppinglist $shoppinglist)
    {
        return view('shoppinglist.edit')->with('shoppinglist', $shoppinglist);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shoppinglist  $shoppinglist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shoppinglist $shoppinglist)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);
        $shoppinglist->update([
            'name' => $request->name,
            'note' => $request->note
        ]);
        return $this->index()->with([
            'meldung success' => 'Die Liste '.$request->name.' wurde editiert'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shoppinglist  $shoppinglist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shoppinglist $shoppinglist)
    {
        $shoppinglist->delete();
        return $this->index()->with([
            'meldung_success' => 'Die Liste wurde gelöscht'
        ]);
    }
}
