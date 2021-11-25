@extends('layouts.app')
@section('content')



    <div class="container">
        <div class="card-header"><h3>{{$shoppinglist->name}}</h3></div>
        <div class="card-body">
            <img class="img-fluid" src="{{URL::asset($shoppinglist->bild)}}" alt="">


            <div class="form-group">
                <div id="sortable" class="product-list text-center" data-id="{{$shoppinglist->id}}">


                    @foreach($products AS $product)
                        <div id="product_{{ $product->id }}"
                             class="btn btn-primary btn-sm mt-1 ui-sortable-handle mr-auto ml-auto shoplist">{{$product->name}}
                            <button type="button" onclick="removeProduct({{$product->id}})"
                                    class="float-right btn btn-danger btn-sm ml-1"
                                    data-id={{$product->id}}><i
                                    class="fa fa-minus"> </i></button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex-column" id="">{{$shoppinglist->note}}</div>

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
            console.log('product_id:' + product_id);
            $('#product_' + product_id).remove();
            $.ajax({
                method: "POST",
                url: "/shoppinglist/ajax-delete-product",
                data: {
                    _token: "{{ csrf_token() }}",
                    shoppinglist_id: {{ $shoppinglist->id }},
                    product_id: product_id
                },
                success: function (data) {
                    $('.ajax-alert').text(data['message']);
                },
                error: function (response) {
                    console.log('Error:', response);
                }
            });
            return false;

        }
    </script>
@endsection
