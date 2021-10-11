@extends('layouts/app')
@section('content')
    <div class="container">
        <h1>Index Rezepte</h1>



        {{--{{DB::table('shoppinglists')->where('id','=','5')->get()}}--}}
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Rezepte</div>
                    <div class="card-body">
                        <table class="border-left border-right table-striped table">
                            <thead>
                            <tr>
                                <th>Rezept</th>
                                <th>Zutaten</th>
                                <th>Hinzufügen</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recipes AS $recipe)
                                <tr>
                                    <td>
                                        <a href="/recipe/{{$recipe -> id}}/edit">{{$recipe -> name}}</a>
                                    </td>

                                    <td>
                                    @foreach($recipe->products()->pluck('name') as $name)
                                        <div class="btn btn-outline-success">{{$name}}</div>
                                        @endforeach
                                        </td>

                                    <td><a href="/recipe/{{$recipe->id}}/edit"
                                           class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form method="POST" action="/recipe/{{$recipe->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm rounded-circle"><i
                                                    class="fa fa-minus"></i></button>
                                        </form>
                                    </td>
                                    <td>{{$recipe -> updated_at  ?? $recipe -> created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
{{--        @auth--}}
            <a class="btn btn-success" href="/recipe/create"><i class="fa fa-plus"></i></a>
{{--        @endauth--}}
        <div class="container">
            {{ $recipes->links("pagination::bootstrap-4") }}
        </div>
    </div>
@endsection
