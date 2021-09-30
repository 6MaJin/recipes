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
                                <th>Besitzer</th>
                                <th>Anzahl_Listen</th>
                                <th>Produkte</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$shoppinglist->name}}</td>
                                <td>{{$shoppinglist->note}}</td>
                                <td><a href="/user/{{$shoppinglist->user_id}}">{{$shoppinglist->user->name}}</a></td>
                                <td> {{ $shoppinglist->user->shoppinglists->count('name') }}</td>
                            <!--                                   <td> <ul>
                                        @foreach($shoppinglist->products as $product)
                                <li><a href="/product/{{$product->id}}">{{$product->name}}</a></li>
                                        @endforeach
                                </ul>
                            </td>-->
                                <td>
                                    <ul>
                                        @foreach($shoppinglist->products as $product)
                                            <li class="btn-outline-success list-item sort_menu"><a
                                                    data-id="{{$product->id}}"
                                                    class="btn btn-outline-success list-item sort_menu"
                                                    href="/product/{{$product->id}}">{{$product->name}}</a></li>
                                        @endforeach

                                    </ul>

                                </td>
                                <td><a href="/shoppinglist/{{$shoppinglist->id}}/edit"
                                       class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    <form method="POST" action="/shoppinglist/{{$shoppinglist->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-minus"></i>
                                        </button>
                                    </form>
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

    <style>
        .list-group-item {
            display: flex;
            align-items: center;
        }

        .highlight {
            background: #f7e7d3;
            min-height: 30px;
            list-style-type: none;
        }

        .handle {
            min-width: 18px;
            background: #607D8B;
            height: 15px;
            display: inline-block;
            cursor: move;
            margin-right: 10px;
        }
    </style>

    <script>
        $(document).ready(function () {

            function updateToDatabase(idString) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

                $.ajax({
                    url: '{{url('/menu/update-order')}}',
                    method: 'POST',
                    data: {ids: idString},
                    success: function () {
                        alert('Successfully updated')
                        //do whatever after success
                    }
                })
            }

            var target = $('.sort_menu');
            target.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui) {
                    var sortData = target.sortable('toArray', {attribute: 'data-id'})
                    updateToDatabase(sortData.join(','))
                }
            })

        })
    </script>


@endsection
@livewire('productfinder')
@section('after_script')
    <script>


        function addProduct(product_id, product_name) {
            if ($('.product-list').find('[data-id="+product_id+"]').length === 0) {
                $('.product-list').prepend('<div class="btn btn-outline-secondary btn-sm mt-1" onclick="removeProduct(' + product_id + ')" data-id="' + product_id + '">' + product_name + '</div>');
            }
        }

        function removeProduct(product_id) {
            $('.product-list').find('[data-id="+product_id+"]').remove();
        }
    </script>
@endsection
