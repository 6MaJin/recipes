@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{$shoppinglist->name}}</h3></div>
                    <div class="card-body">
                        @php
                            if(isset($shoppinglist->getMedia('images')[0])) {@endphp

                        <img class="img-fluid border-success" src="{{ $shoppinglist->getMedia('images')[0]->getUrl() }}"
                             alt="">
                        @php
                            }
                        @endphp

                        <div class="ajax-alert alert alert-info d-none"></div>
                        <form action="/shoppinglist/{{$shoppinglist->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input value="{{old('name') ?? $shoppinglist->name}}" type="text" class="form-control"
                                       id="name" name="name">

                                <label for="image">Image</label>
                                <input value="{{old('image')}}" type="file" class="form-control"
                                       id="image" name="image">

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="delete_image"
                                           value="1"
                                           id="delete_image">
                                    <label class="custom-control-label"
                                           for="delete_image">Bild löschen?</label>
                                </div>


                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="note">Notes</label><br/>
                                    <textarea class="flex-column" name="note"
                                              id="note">{{old('note') ?? $shoppinglist->note}}</textarea>
                                </div>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>

                            </div>
                        </form>
                        <div class="form-group ml-5">
                            <div id="sortable" class="product-list" data-id="{{$shoppinglist->id}}">

                                @foreach($products AS $product)
                                    <div>
                                        <div id="product_{{ $product->id }}"
                                             class="position-relative btn btn-outline-success btn-sm mt-1 ui-sortable-handle">{{$product->pivot->count."x ". $product->name}}
                                        </div>
                                        <button type="button" onclick="removeProduct({{$product->id}})"
                                                class="delete-product-button position-relative btn btn-outline-danger btn-sm"
                                                data-id={{$product->id}}><i
                                                class="fa fa-minus"> </i></button>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="mb-3">
                            <div class="container<!--livesearch-container-->">
                                {{--                                    <livewire:productfinder :shoppinglist="$shoppinglist"/>--}}
                                <input type="text" id="add_product" value="">
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
                    if($('#product_'+data.product_id).length) {
                        if(data.count > 0) {
                            $('#product_'+data.product_id).text(data.count+'x '+data.product_name);
                        } else {
                            $('#product_'+data.product_id).text(data.product_name);
                        }
                    } else {
                        $('.product-list').append('<div class="ui-sortable-handle"><div id="product_' + data.product_id + '" class="position-relative btn btn-outline-success btn-sm mt-1 ui-sortable-handle">' + data.product_name + '</div><button type="button" onclick="removeProduct(' + data.product_id + ')" class="delete-product-button position-relative btn btn-outline-danger btn-sm" data-id=' + data.product_id + '><i class="fa fa-minus"> </i></button></div>');
                    }
                },
                error: function (response) {
                    console.log('Error:', response);
                },
            });
        }

        function removeProduct(product_id) {
            console.log('product_id:' + product_id);

            if() {

            }

            else {
                $('#product_' + product_id).parent().remove();

            }

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
