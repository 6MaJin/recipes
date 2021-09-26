<div class="livesearch">

    <input wire:model="search" type="text" placeholder="Search Products..."/>
    <ul class="list-group">
        @foreach($products as $product)

            <li class="list-group-item" onclick="addProduct({{$product->id}},'{{$product->name}}')">{{ $product->name }}</li>

        @endforeach

    </ul>

</div>
