
<!-- ============================================= -->
<!-- resources/views/posts/index.blade.php -->
<!-- ============================================= -->
@extends('layouts.app2')

@section('title', 'All Posts')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-1">Blog Posts</h1>
                    <p class="text-muted mb-0">Discover and manage all blog content</p>
                </div>
                @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Create New Post
                </a>
                @endcan
            </div>
        </div>
    </div>
    
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('posts.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search posts..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Author</label>
                            <select name="user" class="form-select">
                                <option value="">All Authors</option>
                                @if(request('user') == Auth::id())
                                <option value="{{ Auth::id() }}" selected>My Posts</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Posts Table -->
    <div class="row">
        <div class="col-12">
            @if($posts->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                        <strong>{{ Str::limit($post->title, 50) }}</strong>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle text-muted me-2"></i>
                                        {{ $post->user->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $post->status }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($post->published_at)
                                        {{ $post->published_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-light" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @can('update', $post)
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-light" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('publish', $post)
                                            @if($post->status !== 'published')
                                            <form action="{{ route('posts.publish', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Publish">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </form>
                                            @endif
                                        @endcan
                                        
                                        @can('delete', $post)
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
            @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">No posts found</h5>
                    <p class="text-muted">There are no posts matching your criteria.</p>
                    @can('create', App\Models\Post::class)
                    <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-lg"></i> Create Your First Post
                    </a>
                    @endcan
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection