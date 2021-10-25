@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-4">

                <ul class="sort_menu list-group">
                    @foreach ($data as $row)
                        <li class="list-group-item" data-id="{{$row->id}}">
                            <span class="handle"></span> {{$row->label}}</li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
    <style>
        .list-group-item {
            display: flex;
            align-items: center;
        }

        .highlight {
            background: #f7e7d3;
            min-height: 30px;
            list-style-type: none;
        }

        .handle {
            min-width: 18px;
            background: #607D8B;
            height: 15px;
            display: inline-block;
            cursor: move;
            margin-right: 10px;
        }
    </style>

    <script>
        $(document).ready(function(){

            function updateToDatabase(idString){
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

                $.ajax({
                    url:'{{url('/menu/update-order')}}',
                    method:'POST',
                    data:{ids:idString},
                    success:function(){
                        alert('Successfully updated')
                        //do whatever after success
                    }
                })
            }
            var target = $('.sort_menu');
            target.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui){
                    var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','))
                }
            })
        })
    </script>
@endsection
