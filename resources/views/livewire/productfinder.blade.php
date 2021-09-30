<div class="livesearch">
    <input wire:model="search" type="text" name="add_product" id="add_product" placeholder="Add Products..."/>
    <ul class="list-group">
        @foreach($products as $product)

            <li class="list-group-item" onclick="addProduct({{$product->id}},'{{$product->name}}')">{{ $product->name }}</li>

        @endforeach

    </ul>

</div>
