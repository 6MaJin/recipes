@extends('layouts/app')
@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Produkt</th>
                <th>Kategorien</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td>{{$product->name}}</td>
                <td>@foreach($product->categories as $category)
                        <ul>
                            <li>{{$category->name}}</li>
                        </ul>
                    @endforeach
                </td>
            </tr>
            </tbody>
        </table>


    <!--        <li><a href="/product/{{$product->id}}">{{$product->name}}</a></li>-->

    </div>
@endsection
