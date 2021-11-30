@extends('layouts/app')
@section('content')

    <div class="container">

        <h1 class="text-light">Unsere Rezepte</h1>

        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Rezeptauswahl</div>
                    <div class="card-body">
                        <table class="border-bottom border-left border-right table-striped table">
                            <thead class="text-light">
                            <tr>
                                <th>Rezept</th>
                                <th>Eingestellt von:</th>
                                <th>Add Recipe</th>
                                <th>Geändert am:</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppinglists AS $shoppinglist)
                                <tr>
                                    <td>
                                        <a href="/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a>
                                    </td>
                                    <td>
                                        <a href="/user/{{$shoppinglist->user_id}}">{{$shoppinglist->user->name}}</a>
                                    </td>
                                    <td>
                                        @auth
                                            <button class="add_recipe btn btn-success"
                                                    data-id="{{$shoppinglist -> id}}"><i class="fa fa-plus"></i>
                                            </button>
                                        @endauth
                                    </td>


                                    <td class="text-light">{{$shoppinglist -> updated_at  ?? $shoppinglist -> created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{ $shoppinglists->links("pagination::bootstrap-4") }}
        </div>
    </div>
@endsection
@section('after_script')
    <script>

    </script>

@endsection
@section('after_script')

@endsection
