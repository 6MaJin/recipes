@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h1>Admin User</h1>

        {{--{{DB::table('shoppinglists')->where('id','=','5')->get()}}--}}
        <div class="row justifiy-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle User</div>
                        <div class="card-body">
                            <table class="border-left border-right table-striped table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Shoppinglisten</th>
                                    <th>Produkte</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Make Admin</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                <tr>
                                    <td><a href="/user/{{$user->id}}">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @foreach($user->shoppinglists as $shoppinglist)
                                            <a href="/shoppinglist/{{$shoppinglist->id}}">{{$shoppinglist->name}}</a><br/>
                                        @endforeach
                                    </td>

                                    <td><a href="/user/{{$user->id}}/edit" class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-edit"></i></a></td>
                                    <td>
                                        <form method="POST" action="/user/{{$user->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-minus"></i></button>
                                        </form>
                                    </td>
                                    <td>{{$shoppinglist -> created_at}}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" data-id="{{$user -> id}}"
                                                   class="admin_switch custom-control-input"
                                                   name="is_admin_{{$user -> id}}"
                                                   id="is_admin_{{$user -> id}}" {{$user->is_admin == 1 ? "checked" : ""}}>
                                            <label class="custom-control-label"
                                                   for="is_admin_{{$user -> id}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>


                        </div>

                </div>
            </div>
        </div>
        @auth
        <a class="btn btn-success" href="/user/create"><i class="fa fa-plus"></i></a>
        @endauth
        <div class="container">
            {{ $users->links("pagination::bootstrap-4") }}
        </div>



    </div>

@endsection
@section('after_script')
    <script>
        $(function () {
            $('.admin_switch').change(function (e) {
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "/admin/user/ajax-set-admin",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: $(this).data('id'),
                        is_admin: $(this).is(':checked')==true?1:0
                    },
                    success: function () {
                        console.log("It works");
                    },
                    error: function (response) {
                        console.log('Error:', response);
                    }
                });
            });
        });
    </script>
@endsection
