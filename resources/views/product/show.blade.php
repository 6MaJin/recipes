@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Notes</th>
                                <th>Produkte</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->note}}</td>
                                <td>
                                    <ul>
                                        {{--@foreach($product->category()->pluck('name') as $name)
                                            <li><a href="/product/show">{{$name}}</a></li>
                                        @endforeach--}}
                                    </ul>
                                </td>
                                <td><a href="/shoppinglist/{{$product->id}}/edit"
                                       class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    <form method="POST" action="/shoppinglist/{{$product->id}}">
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
