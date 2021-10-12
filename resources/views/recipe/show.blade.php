@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{$recipe->name}}</h3></div>
                    <div class="card-body">


                    <div class="card-header">
                        <h4>Add Product</h4>
                    </div>
                        <div class="card-body">
                            <form method="POST" action="/product">
                                @csrf
                                <input id="name" name="name" class type="text">
                                <button class="btn btn-success" type="text"><i class="fa fa-plus"></i></button>
                            </form>
                        </div>



                    </div>

                    @endsection

                    @section('after_script')
                        <script>
                            function addProduct(product_id, product_name) {
                                if ($('.product-list').find("[data-id=" + product_id + "]").length === 0) {
                                    $('.product-list').append('<div class="list-button btn btn-outline-secondary btn-sm mt-1">' + product_name + '</div>');

                                }
                            }

                            function ajaxStore() {
                                let product_name = $("#add_product").val();
                                $.ajax({
                                    method: "POST",
                                    dataType: 'json',
                                    url: "{{route('product.ajax-store')}}",
                                    data: {_token: "{{ csrf_token() }}", name: product_name, recipe_id: {{ $recipe->id }}}
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
