@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">


                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Über mich</th>
                                <th>Meine Listen</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <td>{{$user->name}}</td>
                                <td>{{$user->ueber_mich}}</td>
                                <td>
                                    @foreach($user->shoppinglists as $shoppinglist)
                                        <li><a href="/product/{{$shoppinglist->id}}">{{$shoppinglist->name}}</a></li>
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
