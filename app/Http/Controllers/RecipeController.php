<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Shoppinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::orderBy('id', 'ASC')->paginate(5);
        return view('recipe.index')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('recipe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        /*dd($request);*/
        $request->validate(Recipe::$rules);
        $recipe = new Recipe([
            'name' => $request['name'],
            'note' => $request['note'],
//            'user_id' => auth()->id()
        ]);
        $recipe->save();
        return redirect('/recipe')->with([
            'meldung_success' => 'Das Rezept '.$recipe->name.' wurde angelegt'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(recipe $recipe)
    {
        //
    }
    public function create_shoppinglist() {
        $shoppinglist = new Shoppinglist([
            'name' => $this['name'],
            'note' => $this['note'],
            'user_id' => auth()->id()
        ]);
    }
}
