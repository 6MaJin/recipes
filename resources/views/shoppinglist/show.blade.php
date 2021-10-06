@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">


                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        @livewire('productfinder')
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">

                                            <div id="sortable" class="product-list" data-id="{{$shoppinglist->id}}">

                                                @foreach($shoppinglist->products()->orderBy('product_shoppinglist.sort','ASC')->get() as $product)
                                                    <div class="btn btn-outline-secondary btn-sm mt-1 ui-sortable-handle"
                                                         data-id={{$product->id}}>{{$product->name}}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

@endsection

@section('after_script')
                        <script>
                            function addProduct(product_id, product_name) {
                                if ($('.product-list').find("[data-id=" + product_id + "]").length === 0) {
                                    $('.product-list').append('<div class="btn btn-outline-secondary btn-sm mt-1">' + product_name + '</div>').append("terter");

                                }
                            }

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
                                            $('.product-list').append('<div class="btn btn-outline-secondary btn-sm mt-1" onclick="removeProduct(' + data.product_id + ')" data-id="' + data.product_id + '">' + data.product_name + '</div>');
                                        }
                                    });
                            }

                            function removeProduct(product_id) {
                                return;
                                $('.product-list').find("[data-id=" + product_id + "]").remove();
                            }
                        </script>
@endsection
