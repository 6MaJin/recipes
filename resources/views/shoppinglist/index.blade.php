@extends('layouts.app')
@section('content')
    <div class="container">

        <h1 class="text-light">Index ShoppingList</h1>

        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">
                        <table class="border-left border-right table-striped table">
                            <thead>
                            <tr>
                                <th>Liste</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th class="">Zuletzt bearbeitet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppinglists AS $shoppinglist)
                                <tr id="row_{{$shoppinglist->id}}" data-row_id="{{$shoppinglist->id}}">
                                    <td>
                                        <a href="/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a>
                                    </td>
                                    <td><a href="/shoppinglist/{{$shoppinglist->id}}/edit"
                                           class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger fa fa-minus"
                                                onclick="removeShoppinglist({{$shoppinglist->id}})"
                                                data-shoppinglist_id={{$shoppinglist->id}} id="shoppinglist_id={{$shoppinglist->id}}"></button>
                                    </td>
                                    <td>{{$shoppinglist->updated_at}}</td>
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
    <div class="container bg-light">
        <ul>
            @foreach($products AS $product)
                <li>{{ $product->id }} -
                    {{ $product -> shoppinglists()->pluck('id')}}
                </li>
            @endforeach

        </ul>
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
                        public: $(this).is(':checked') == true ? 1 : 0
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
                    $('tbody').find("[data-row_id='" + shoppinglist_id + "']").remove();
                },
            });
        }

        function ajaxStatus(data) {
            $('.ajax-status').removeClass('d-none').append(data['success'] + "<br>");
            console.log('Kuckuck!');

        }

    </script>
@endsection
