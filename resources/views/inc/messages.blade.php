@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="container">
            <div class="alert alert-danger">
                {!! $error !!}
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

