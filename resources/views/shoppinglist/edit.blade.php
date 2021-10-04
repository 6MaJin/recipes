@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
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
                                    @foreach($shoppinglist->products as $product)
                                        <div class="btn btn-outline-secondary btn-sm mt-1 ui-sortable-handle"
                                             data-id={{$product->id}}>{{$product->name}}</div>
                                    @endforeach
                                </div>
                            </div>



                            {{$product -> sortedProducts}}

                            <div class="mb-3">
                                <div class="livesearch-container">
                                    <livewire:productfinder :shoppinglist="$shoppinglist"/>
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
        function addProduct(product_id, product_name) {
            if ($('.product-list').find("[data-id=" + product_id + "]").length === 0) {
                $('.product-list').append('<div class="btn btn-outline-secondary btn-sm mt-1" onclick="removeProduct(' + product_id + ')" data-id="' + product_id + '">' + product_name + '</div>');

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
