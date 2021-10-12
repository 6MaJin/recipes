<div class="livesearch input-group">
    <input wire:model="search" class="form-control" type="text" name="add_product" id="add_product" placeholder="Add Products..."/>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="ajaxStore()"><i class="fa fa-plus">Speichere Produkt</i>
        </button>
    </div>
    <ul>
        @foreach($products as $product)

<!--            <li class="list-group-item" onclick="addProduct({{$product->id}},'{{$product->name}}')">{{ $product->name }}</li>-->
            <li class="list-group-item">{{ $product->name }}</li>

        @endforeach
    </ul>


</div>
