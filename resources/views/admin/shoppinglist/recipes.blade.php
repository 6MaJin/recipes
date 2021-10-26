@extends('admin.layouts/app')
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
                                <th>Add Recipe</th>
                                <th>Edit</th>
                                <th>Delete</th>

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



    <div class="mt-5 container">
        <ul>
            @foreach($shoppinglists AS $shoppinglist)
                <li><a href="shoppinglist/{{$shoppinglist->id}}/edit">{{$shoppinglist->name}}</a></li>
            @endforeach
        </ul>
        <img class="img-thumbnail" src="{{ asset('images/gruene_soße .jpeg') }}" alt="">
        <div class="mt-5 recipe container-fluid">
            <h1>Rezept: Grüne Soße</h1>
            <p>Grüne Soße, ein Klassiker der regionalen Küche. Sobald im Frühsommer die Kräuter sprießen werden
                Schnittlauch, Borretsch, Pimpinelle, Kerbel, Sauerampfer, Petersilie und Kresse wieder zur Grundlage
                dieser cremig-kühlen Kräutersoße, die ideal zu Spargel, Roastbeef, gekochte Landeier, Grillgemüse oder
                einfach Pellkartoffeln passt.
                <br><br>

                Aber Hand auf’s Herz: Wer kennt heute noch Borretsch, Pimpinelle, Kerbel und Sauerampfer? Grüne Soße
                schmeckt nicht nur köstlich, sie enthält auch kaum bekannte Kräuter, das unsere älteren
                Familienmitglieder für ihre Küche so wunderbar zu nutzen wussten. Lasst uns dieses Wissen auf leckere
                Weise noch möglichst lange erhalten!
                <br><br>

                Sie möchten Grüne Soße auch zu Hause genießen? Hier ist unser Vorschlag für Grüne Soße mit den
                regionalen Kräutern
                Schnittlauch, Borretsch, Pimpinelle, Kerbel, Sauerampfer, Petersilie und Kresse.</p>
        </div>
    </div>

@endsection
@section('after_script')

@endsection
