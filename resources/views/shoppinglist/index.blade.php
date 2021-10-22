@extends('layouts.app')
@section('content')
    <div class="container">

        <h1>Index ShoppingList</h1>

        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">
                        <table class="border-left border-right table-striped table">
                            <thead>
                            <tr>
                                <th>Liste</th>
                                <th>Besitzer</th>
                                <th>Öffentlich</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppinglists AS $shoppinglist)
                                <tr id="row_{{$shoppinglist->id}}" data-row_id="{{$shoppinglist->id}}">
                                    <td>
                                        <a href="/shoppinglist/{{$shoppinglist -> id}}/edit">{{$shoppinglist -> name}}</a>
                                    </td>
                                    <td>
                                        <a href="/user/{{$shoppinglist->user_id}}">{{$shoppinglist->user->name}}</a>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" data-id="{{$shoppinglist -> id}}"
                                                   class="public_switch custom-control-input"
                                                   name="public_{{$shoppinglist -> id}}"
                                                   id="public_{{$shoppinglist -> id}}" {{$shoppinglist->public == 1 ? "checked" : ""}}>
                                            <label class="custom-control-label"
                                                   for="public_{{$shoppinglist -> id}}"></label>
                                        </div>
                                    </td>
                                    <td><a href="/shoppinglist/{{$shoppinglist->id}}/edit"
                                           class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form method="POST" action="/shoppinglist/{{$shoppinglist->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm rounded-circle"><i
                                                    class="fa fa-minus"></i></button>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-outline-danger fa fa-minus" onclick="removeShoppinglist({{$shoppinglist->id}})" data-shoppinglist_id={{$shoppinglist->id}} id="shoppinglist_id={{$shoppinglist->id}}" ></button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @auth
            <a class="btn btn-success" href="/shoppinglist/create"><i class="fa fa-plus"></i></a>
        @endauth
        <div class="container">
            {{ $shoppinglists->links("pagination::bootstrap-4") }}
        </div>
    </div>
@endsection
@section('after_script')
    <script>
        $(function () {


            $('.public_switch').change(function (e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "/shoppinglist/ajax-set-public",
                    data: {
                        _token: "{{ csrf_token() }}",
                        shoppinglist_id: $(this).data('id'),
                        public: $(this).is(':checked')==true?1:0
                    },
                    success: function () {
                        console.log("It works");

                    },
                    error: function (response) {
                        console.log('Error:', response);
                    }
                });
            });
        });


        function removeShoppinglist(shoppinglist_id) {

            $.ajax({
                method: "POST",
                url: "/shoppinglist/ajax-delete-shoppinglist",
                data: {
                    _token: "{{ csrf_token() }}",
                    shoppinglist_id: shoppinglist_id,
                },
                success: function (data) {
                    ajaxStatus(data);
                    /*$("#row_id'"+shoppinglist_id+"']").remove();*/
                    $('tbody').find("[data-row_id='"+shoppinglist_id+"']").remove();
                },
            });
        }

        function ajaxStatus (data) {
            $('.ajax-status').removeClass('d-none').append(data['success']+"<br>");
            console.log('Kuckuck!');

        }

    </script>
@endsection
