@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>
    
    <div class="card">

    </div>
    <!-- Search Form -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3 mt-6">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request()->query('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Verify</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection