@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Produkte von {{ $user->name }}</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Shoppinglisten</th>
                                <th>Produkte</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->shoppinglists as $shoppinglist)
                                        <a href="/shoppinglist/{{$shoppinglist->id}}">{{$shoppinglist->name}}</a><br/>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($user->shoppinglists as $shoppinglist)
                                        <h4>{{$shoppinglist->name}}</h4>
                                        @foreach($shoppinglist->products as $product)
                                            <a href="/product/{{$product->id}}">{{$product->name}}</a><br/>
                                        @endforeach
                                    @endforeach
                                </td>
                                    <td><a href="/user/{{$user->id}}/edit"
                                           class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>

                                <td>
                                    <form method="POST" action="/user/{{$user->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-minus"></i></button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-secondary float-right" href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
