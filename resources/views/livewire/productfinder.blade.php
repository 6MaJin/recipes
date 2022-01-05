<div class="livesearch input-group">
    <input wire:model="search" type="text" id="add_product" value="">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2"
            onclick="ajaxStoreProduct()"><i class="fa fa-plus"></i> Produkt hinzufügen
    </button>

    <ul>
        @foreach($products as $product)

        <li class="list-group-item">{{ $product->name }}</li>

        @endforeach
    </ul>


</div>
