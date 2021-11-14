@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{$shoppinglist->name}}</h3></div>
                    <div class="card-body">
                        <div class="ajax-alert alert alert-info d-none"></div>
                        <form action="/shoppinglist/{{$shoppinglist->id}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input value="{{old('name') ?? $shoppinglist->name}}" type="text" class="form-control"
                                       id="name" name="name">

                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="note">Notes</label><br/>
                                    <textarea class="flex-column" name="note" id="note" >{{old('note') ?? $shoppinglist->note}}</textarea>
                                </div>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>

                            </div>
                        </form>
                            <div class="form-group ml-5">
                                <div id="sortable" class="product-list" data-id="{{$shoppinglist->id}}">

                                    @foreach($products AS $product)
                                        <div id="product_{{ $product->id }}"
                                             class="btn btn-outline-success btn-sm mt-1 ui-sortable-handle">{{$product->name}}
                                            <button type="button" onclick="removeProduct({{$product->id}})"
                                                    class="float-right btn btn-outline-danger btn-sm"
                                                    data-id={{$product->id}}><i
                                                    class="fa fa-minus"> </i></button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="mb-3">
                                <div class="container<!--livesearch-container-->">
                                    {{--                                    <livewire:productfinder :shoppinglist="$shoppinglist"/>--}}
                                    <form action="">
                                        <input onfocus="this.value=''" type="text" id="add_product" id="name" value="">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                                                onclick="ajaxStoreProduct()"><i class="fa fa-plus">Produkt hinzufügen</i>
                                        </button>
                                    </form>
                                </div>

                            </div>



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
                    $('.ajax-alert').removeClass('d-none').text(data['message']);
                    $('.product-list').append('<div id="product_' + data.product_id + '" class="btn btn-outline-success btn-sm mt-1" data-list_id="' + data.shoppinglist_id + '"  data-id="' + data.product_id + '">' + data.product_name + '<i onclick="removeProduct(' + data.product_id + ')" class="float-right btn-sm btn btn-outline-danger fa fa-minus"></i></div>');

                },
                error: function (response) {
                    console.log('Error:', response);
                },
            });
        }
        function removeProduct(product_id) {
            console.log('product_id:'+product_id);
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
