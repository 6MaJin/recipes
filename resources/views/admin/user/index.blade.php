@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h1>Index User</h1>

        {{--{{DB::table('shoppinglists')->where('id','=','5')->get()}}--}}
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle User</div>
                        <div class="card-body">
                            <table class="border-left border-right table-striped table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Shoppinglisten</th>
                                    <th>Produkte</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                <tr>
                                    <td><a href="/user/{{$user->id}}">{{$user->name}}</a></td>
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
                                    <td><a href="/user/{{$user->id}}/edit" class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>
                                    <td>
                                        <form method="POST" action="/user/{{$user->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-minus"></i></button>
                                        </form>
<!--                                        <div class="d-flex float-right">{{$user->created_at}}</div>-->
                                    </td>
                                    <td>{{$shoppinglist -> created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>

                </div>
            </div>
        </div>
        @auth
        <a class="btn btn-success" href="/user/create"><i class="fa fa-plus"></i></a>
        @endauth
        <div class="container">
            {{ $users->links("pagination::bootstrap-4") }}
        </div>



    </div>
@endsection
