@extends('admin.layouts/app')
@section('content')

    <div class="container">

        <h1 class="text-light">Alle Rezepte</h1>
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Rezeptverwaltung</div>
                    <div class="card-body">
                        <table class="border-left border-right table-striped table">
                            <thead>
                            <tr>
                                <th>Rezept</th>
                                <th>Besitzer</th>
                                <th>Add Recipe</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Geändert am</th>
                                <th>Freigeben</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppinglists AS $shoppinglist)
                                <tr>
                                    <td>
                                        <a href="/admin/shoppinglist/{{$shoppinglist -> id}}">{{$shoppinglist -> name}}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/user/{{$shoppinglist->user_id}}">{{$shoppinglist->user->name}}</a>
                                    </td>
                                    <td>
<!--                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" data-id="{{$shoppinglist -> id}}"
                                                   class="public_switch custom-control-input"
                                                   name="public_{{$shoppinglist -> id}}"
                                                   id="public_{{$shoppinglist -> id}}" {{$shoppinglist->public == 1 ? "checked" : ""}}>
                                            <label class="custom-control-label"
                                                   for="public_{{$shoppinglist -> id}}"></label>
                                        </div>-->
                                        <button class="add_recipe btn btn-success" data-id="{{$shoppinglist -> id}}"><i class="fa fa-plus"></i></button>
                                    </td>
                                    <td><a href="/admin/shoppinglist/{{$shoppinglist->id}}/edit"
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
                                    <td>{{$shoppinglist -> updated_at  ?? $shoppinglist -> created_at}}</td>
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
        $(function () {


            $('.public_switch').change(function (e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "/admin/shoppinglist/ajax-set-public",
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



        $(function () {
            $('.add_recipe').click(function(e) {
                var shoppinglist_id = $(this).data('id');
                /*var route = "/shoppinglist/"+shoppinglist_id+"/ajax-add";*/

                $.ajax({
                    method: "GET",
                    url: "/shoppinglist/"+shoppinglist_id+"/ajax-add-recipe",
                    data: {
                        _token: "{{ csrf_token() }}",
                        shoppinglist_id: $(this).data('id'),
                        'success': 'Hello there',
                        'error': 'ERROR!'
                    },

                    /*success: function (data) {
                        $('.card-header').prepend("<div class='alert alert-success alert-solid alert-dismissible shadow-sm p-3 mb-5 rounded' role='alert'>"+data['success']+"</div>");

                    },*/
                    success: function (data) {
                        ajaxStatus(data);
                    },
                    error: function (response) {
                        console.log('Error:', response);
                    }

                });

                /*$.get(route , function(data){

            });*/


        });
 });


            function ajaxStatus (data) {
            $('.ajax-status').removeClass('d-none').append(data['success']+"<br>");
            console.log('Kuckuck!');
        }
    </script>




@endsection
@section('after_script')

@endsection
