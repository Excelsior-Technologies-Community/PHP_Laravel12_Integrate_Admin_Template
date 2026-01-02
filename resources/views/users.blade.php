@extends('theme.default') {{-- Use admin layout --}}

@section('content')
<div class="container-fluid px-4">

    {{-- Page heading --}}
    <h1 class="mt-4">Users</h1>

    {{-- Users table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td> {{-- User ID --}}
                <td>{{ $user->name }}</td> {{-- User name --}}
                <td>{{ $user->email }}</td> {{-- User email --}}
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
