@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="ajax-alert alert alert-info d-none"></div>
        <div class="row">
            <div class="col-md-12 justify-content-center d-inline-flex">
                <div class="card">
                    <div class="card-header"><h3>{{$shoppinglist->name}}</h3></div>
                    <div class="card-body">

                        <div class="form-group">
                            <div id="sortable" class="product-list text-center" data-id="{{$shoppinglist->id}}">

                                @foreach($products AS $product)
                                    <div>
                                        <div id="product_{{ $product->id }}"
                                             class="pl-show btn btn-primary mb-1 ui-sortable-handle">{{$product->pivot->count."x ". $product->name}}</div><button type="button" onclick="removeProduct({{$product->id}})"
                                                class="delete-product-button position-relative btn btn-outline-danger btn-sm"
                                                data-id={{$product->id}}><i
                                                class="fa fa-minus"> </i></button>
                                    </div>
                                @endforeach

                            </div>
                            <div class="mb-3">
                                <div class="container<!--livesearch-container-->">
                                    {{--                                    <livewire:productfinder :shoppinglist="$shoppinglist"/>--}}
                                    <input type="text" id="add_product" value="" onclick="ajaxStoreProduct()">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                                            onclick="ajaxStoreProduct()"><i class="fa fa-plus"></i> Produkt hinzufügen
                                    </button>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('after_script')
    <script>

        function ajaxStoreProduct() {
            let product_name = $("#add_product").val();

            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "{{route('product.ajax-store-product')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: product_name,
                    shoppinglist_id: {{ $shoppinglist->id }},
                },
                success: function (data) {
                    $('.ajax-alert').removeClass('d-none').text(data.message);
                    if ($('#product_' + data.product_id).length) {

                            $('#product_' + data.product_id).text(data.count + 'x ' + data.product_name);

                    } else {
                        $('.product-list').append('<div class="ui-sortable-handle"><div id="product_' + data.product_id + '" class="position-relative btn btn-primary btn-sm mb-1 pl-show">' + data.count + 'x ' + data.product_name + '</div><button type="button" onclick="removeProduct(' + data.product_id + ')" class="delete-product-button position-relative btn btn-outline-danger btn-sm" data-id=' + data.product_id + '><i class="fa fa-minus"> </i></button></div>');
                    }
                },
                error: function (response) {
                    console.log('Error:', response);
                },
            });
        }

        function removeProduct(product_id) {
            console.log('product_id:' + product_id);
            $.ajax({
                method: "POST",
                url: "/shoppinglist/ajax-delete-product",
                data: {
                    _token: "{{ csrf_token() }}",
                    shoppinglist_id: {{ $shoppinglist->id }},
                    product_id: product_id
                },
                success: function (data) {

                    if (data.count > 0) {
                        $('#product_' + data.product_id).text(data.count + 'x ' + data.product_name);
                    } else {
                        $('#product_' + product_id).parent().remove();
                    }


                    $('.ajax-alert').removeClass('d-none').text(data['message']);
                },
                error: function (response) {
                    console.log('Error:', response);
                }
            });
            return false;
        }
    </script>
@endsection
