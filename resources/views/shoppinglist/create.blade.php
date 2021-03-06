@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">

                        <form action="/shoppinglist" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }} " value="{{old('name')}}" type="text" id="name" name="name">
                                <small class="form-text text-danger">{!!  $errors->first('name') !!}</small>
                            </div>

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

                            <div class="form-group">
                                <label for="note">Notes</label>
                                <textarea class="form-control" name="note" id="note" cols="30" rows="10">{{old('note')}}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                        </form>
                        <a class="btn btn-secondary float-right" href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
