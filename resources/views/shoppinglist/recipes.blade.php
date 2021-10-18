@extends('layouts/app')
@section('content')



    <div class="mt-5 container">
        <ul>
            @foreach($shoppinglists AS $shoppinglist)
                <li><a href="shoppinglist/{{$shoppinglist->id}}/edit">{{$shoppinglist->name}}</a></li>
            @endforeach
        </ul>
        <img class="img-thumbnail" src="http://localhost:8000/gruene_sauce.jpeg" alt="">
        <div class="mt-5 recipe container-fluid">
            <h1>Rezept: Grüne Soße</h1>
            <p>Grüne Soße, ein Klassiker der regionalen Küche. Sobald im Frühsommer die Kräuter sprießen werden
                Schnittlauch, Borretsch, Pimpinelle, Kerbel, Sauerampfer, Petersilie und Kresse wieder zur Grundlage
                dieser cremig-kühlen Kräutersoße, die ideal zu Spargel, Roastbeef, gekochte Landeier, Grillgemüse oder
                einfach Pellkartoffeln passt.
                <br><br>

                Aber Hand auf’s Herz: Wer kennt heute noch Borretsch, Pimpinelle, Kerbel und Sauerampfer? Grüne Soße
                schmeckt nicht nur köstlich, sie enthält auch kaum bekannte Kräuter, das unsere älteren
                Familienmitglieder für ihre Küche so wunderbar zu nutzen wussten. Lasst uns dieses Wissen auf leckere
                Weise noch möglichst lange erhalten!
                <br><br>

                Sie möchten Grüne Soße auch zu Hause genießen? Hier ist unser Vorschlag für Grüne Soße mit den
                regionalen Kräutern
                Schnittlauch, Borretsch, Pimpinelle, Kerbel, Sauerampfer, Petersilie und Kresse.</p>
        </div>

    </div>

@endsection
