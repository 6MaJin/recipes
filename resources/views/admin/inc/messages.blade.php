@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="container">
            <div class="alert alert-danger">
                Bitte überprüfe deine Eingaben
            </div>
            <div class="alert alert-danger">
               {!!  $error !!}
            </div></div>
    @endforeach
@endif


@isset($meldung_success)
    <div class="container">
        <div class="alert alert-success">
            {!! $meldung_success !!}
        </div>
    </div>
@endisset

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif

@if( Session::has("success") )
    <div class="alert alert-success alert-block" role="alert">
        <button class="close" data-dismiss="alert"></button>
        {{session('success')}}
    </div>
@endif

