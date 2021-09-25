@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Listen</div>
                    <div class="card-body">
                        <form action="/shoppinglist" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input value="{{old('name')}}" type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="note">Notes</label>
                                <textarea name="note" id="note" cols="30" rows="10">{{old('note')}}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                        </form>
                        <a class="btn btn-secondary float-right" href="shoppinglist"><i class="fa fa-arrow-circle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
