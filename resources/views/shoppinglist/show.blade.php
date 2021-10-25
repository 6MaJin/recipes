@extends('layouts/app')
@section('content')
    <div class="container">



        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$shoppinglist->name}}</div>
                    <div class="card-body">
                        <!-- Trigger the modal with a button -->

                        <div id="sortable" class="product-list" data-id="{{$shoppinglist->id}}">
                            @foreach($shoppinglist->products()->orderBy('product_shoppinglist.sort','ASC')->get() as $product)
                                <div class="list-button btn btn-outline-secondary btn-sm mt-1 ui-sortable-handle"
                                     data-id={{$product->id}}>{{$product->name}}</div>
                            @endforeach
                        </div>
                    </div>

@endsection

@section('after_script')
                        <script>
                            function ajaxStore() {
                                let product_name = $("#add_product").val();
                                $.ajax({
                                    method: "POST",
                                    dataType: 'json',
                                    url: "{{route('product.ajax-store')}}",
                                    data: {_token: "{{ csrf_token() }}", name: product_name, shoppinglist_id: {{ $shoppinglist->id }}}
                                })
                                    .done(function (data) {
                                        console.log(data);
                                        if (data.status == 'success') {
                                            $('.product-list').append('<div class="list-button btn btn-outline-secondary btn-sm mt-1" onclick="removeProduct(' + data.product_id + ')" data-id="' + data.product_id + '">' + data.product_name + '</div>');
                                        }
                                    });
                            }

                            function removeProduct(product_id) {
                                return;
                                $('.product-list').find("[data-id=" + product_id + "]").remove();
                            }
                        </script>
@endsection
