@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $product->shoppinglists->pluck('name') }}</div>
                    <div class="card-body">


                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>Produkt</th>
                                <th>Kategorien</th>
                                <th>asd</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <td>{{$product->name}}</td>
                                <td>@foreach($product->categories as $category)
                                        <ul>

                                            <li>{{$category->name}}</li>
                                        </ul>
                                        <td>{{$product->shoppinglists->count('name')}}</td>
                                    @endforeach

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-secondary float-right" href="{{ URL::previous() }}"><i
                                class="fa fa-arrow-circle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
