@extends('layouts.app')
@section('content')
    <div class="container">

        <h1 class="text-light">Index ShoppingList</h1>

        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-light card-header bg-dark">Alle Listen</div>
                    <div class="card-body bg-dark">
                        <table class="table-dark table-sm table-striped table">
                            <thead>
                            <tr>
                                <th class="px-3">Liste</th>
                                <th class="d-none d-sm-table-cell px-3 table-date-width">Zuletzt bearbeitet</th>
                                <th class="px-3 table-edit-width">Edit</th>
                                <th class="px-3 table-delete-width">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppinglists AS $shoppinglist)
                                <tr id="row_{{$shoppinglist->id}}" data-row_id="{{$shoppinglist->id}}">
                                    <td class="px-3">
                                        <a href="/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a>
                                    </td>
                                    <td class="d-none d-sm-table-cell px-3">{{$shoppinglist->updated_at}}</td>
                                    <td class="px-3"><a href="/shoppinglist/{{$shoppinglist->id}}/edit"
                                           class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td class="px-3">
                                        <button type="button" class="btn btn-outline-danger fa fa-minus btn-sm"
                                                onclick="removeShoppinglist({{$shoppinglist->id}})"
                                                data-shoppinglist_id={{$shoppinglist->id}} id="shoppinglist_id={{$shoppinglist->id}}"></button>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @auth
                            <a class="btn btn-success" href="{{ route('shoppinglist.create') }}"><i class="fa fa-plus"></i></a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            {{ $shoppinglists->links() }}
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
