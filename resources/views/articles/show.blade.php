@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Articles</h1>

    <!-- Search Form -->
    <form action="{{ route('articles.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search articles..." value="{{ request()->query('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Articles Table -->
    <div class="card">
        <div class="card-header">
            Article List
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ Str::limit($article->content, 50) }}</td>
                        <td>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $articles->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection