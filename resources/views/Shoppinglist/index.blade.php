@extends('layouts/app')
@section('content')
    <div class="container">
        <h1>Index ShoppingList</h1>
        {{DB::table('shoppinglists')->where('id','=','5')->get()}}
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                        <div class="card-body">
                            <table class="border-left border-right table-striped table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>User-ID</th>
<!--                                    <th>Test</th>-->
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($shoppinglists AS $shoppinglist)
                                <tr>
                                    <td><a href="/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a></td>
                                    <td>{{$shoppinglist->id}}</td>
                                    <td>{{$shoppinglist -> user_id}}</td>
<!--                                    <td>{{ print ($shoppinglist) }}</td>-->
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


                        </div>

                </div>
            </div>
        </div>

        <a class="btn btn-success" href="shoppinglist/create"><i class="fa fa-plus"></i></a>
        <div class="container">
            {{ $shoppinglists->links("pagination::bootstrap-4") }}
        </div>



    </div>
@endsection
