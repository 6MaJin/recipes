@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{$shoppinglist->name}}</h3></div>
                    <div class="card-body">
                        <form action="/shoppinglist/{{$shoppinglist->id}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input value="{{old('name') ?? $shoppinglist->name}}" type="text" class="form-control"
                                       id="name" name="name">
                            </div>
                            <div class="form-group">
                                <div id="sortable" class="product-list" data-id="{{$shoppinglist->id}}">
                                    @foreach($products AS $product)
                                        <div id="product_{{ $product->id }}"
                                             class="btn btn-outline-success btn-sm mt-1 ui-sortable-handle">{{$product->name}}
                                            <button type="button" onclick="removeProduct({{$product->id}})"
                                                    class="float-right btn btn-outline-danger btn-sm"
                                                    data-id={{$product->id}}><i
                                                    class="fa fa-minus"> </i></button>
                                            <!--                                                <i onclick="removeProduct(' + data.product_id + ')"
                                                                                             class="float-right btn-sm btn btn-outline-danger fa fa-minus"></i>-->
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="mb-3">
                                <div class="container<!--livesearch-container-->">
                                    {{--                                    <livewire:productfinder :shoppinglist="$shoppinglist"/>--}}
                                    <form action="">
                                        <input type="text" id="add_product" id="name">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                                                onclick="ajaxStore()"><i class="fa fa-plus">Speichere Produkt</i>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <div style="clear:both"></div>
                            <div class="form-group">
                                <label for="note">Notes</label><br/>
                                <textarea name="note" id="note" cols="30"
                                          rows="10">{{old('note') ?? $shoppinglist->note}}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                        </form>
                        <a class="btn btn-secondary float-right" href="{{ URL::previous() }}"><i
                                class="fa fa-arrow-circle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script>
        /*function addProduct(product_id, product_name) {
            if ($('.product-list').find("[data-id=" + product_id + "]").length === 0) {
                $('.product-list').append('<div class="btn btn-outline-secondary btn-sm mt-1">' + product_name + '</div>');

            }
        }*/

        function ajaxStore() {
            let product_name = $("#add_product").val();

            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "{{route('product.ajax-store')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: product_name,
                    shoppinglist_id: {{ $shoppinglist->id }},
                }
            })
                .done(function (data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('.product-list').append('<div id="product_' + data.product_id + '" class="btn btn-outline-success btn-sm mt-1" data-list_id="' + data.shoppinglist_id + '"  data-id="' + data.product_id + '">' + data.product_name + '<i onclick="removeProduct(' + data.product_id + ')" class="float-right btn-sm btn btn-outline-danger fa fa-minus"></i></div>');
                    }

                });
        }



        function removeProduct(product_id) {
            console.log('product_id:'+product_id);
            $('#product_' + product_id).remove();
            $.ajax({
                method: "POST",
                url: "/shoppinglist/ajax-delete",
                data: {
                    _token: "{{ csrf_token() }}",
                    shoppinglist_id: {{ $shoppinglist->id }},
                    product_id: product_id
                },
                success: function () {
                    console.log("It works");
                },
                error: function (response) {
                    console.log('Error:', response);
                }
            });
            return false;

        }
    </script>
@endsection
