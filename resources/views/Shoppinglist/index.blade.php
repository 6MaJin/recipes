@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                        <div class="card-body">
                            <table class="border-left border-right table-striped table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shoppinglists AS $shoppinglist)
                                <tr>
                                    <td><a href="/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a></td>
                                    <td>>{{$shoppinglist -> user_id}}</td>
                                    <td><a href="/shoppinglist/{{$shoppinglist->id}}/edit" class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>
                                    <td>
                                        <form method="POST" action="/shoppinglist/{{$shoppinglist->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-minus"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @foreach($shoppinglists AS $shoppinglist)
                                <div class="card">
                                    {{ $shoppinglist -> name}}
                                    <button class="btn btn-danger"><i class="fa fa-minus"></i></button>
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
