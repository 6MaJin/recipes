@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{$user->name}}</h3>
                    </div>
                    <div class="card-body">
                        <h3>Über mich</h3>
                      {{$user->ueber_mich}}
                    </div>

                     <div class="card-body">
                        <h4>ShoppingLists</h4>


                        <ul class="list-unstyled">
                            @foreach($user->shoppinglists as $shoppinglist)
                               <li><a href="/product/{{$shoppinglist->id}}">{{$shoppinglist->name}}</a></li>
                                @endforeach
                        </ul>
                    </div>


                </div>
                </div>
        </div>
    </div>

@endsection
