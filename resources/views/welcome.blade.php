<!DOCTYPE html>
@extends('layouts/app')
@section('content')

    Welcome
{{Route::current()->getName()}}
@endsection
