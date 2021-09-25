@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                        <div class="card-body">
                            @foreach($shoppinglists AS $shoppinglist)
                                <div class="card">
                                    {{$shoppinglist -> name}}
                                </div>
                            @endforeach
                        </div>

                </div>
            </div>
        </div>

        <a class="btn btn-success" href="shoppinglist/create"><i class="fa fa-plus"></i></a>
        <h1>Index ShoppingList</h1>



    </div>
@endsection
