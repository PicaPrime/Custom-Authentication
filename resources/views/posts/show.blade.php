<!-- ============================================= -->
<!-- resources/views/posts/show.blade.php -->
<!-- ============================================= -->
@extends('layouts.app2')

@section('title', $post->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($post->title, 50) }}</li>
                </ol>
            </nav>
            
            <!-- Alerts -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <!-- Post Card -->
            <article class="card">
                <div class="card-body p-4 p-md-5">
                    <!-- Post Header -->
                    <header class="mb-4">
                        <h1 class="h1 mb-3">{{ $post->title }}</h1>
                        
                        <div class="d-flex flex-wrap align-items-center gap-3 post-meta">
                            <div>
                                <i class="bi bi-person-circle"></i>
                                <strong>{{ $post->user->name }}</strong>
                                <span class="role-badge role-{{ $post->user->role }}">
                                    {{ $post->user->role }}
                                </span>
                            </div>
                            <div>
                                <i class="bi bi-calendar3"></i>
                                {{ $post->created_at->format('F j, Y') }}
                            </div>
                            <div>
                                <i class="bi bi-clock"></i>
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                            <div>
                                <span class="status-badge status-{{ $post->status }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($post->published_at && $post->status === 'published')
                        <div class="mt-2 text-success small">
                            <i class="bi bi-check-circle"></i> Published on {{ $post->published_at->format('F j, Y \a\t g:i A') }}
                        </div>
                        @endif
                    </header>
                    
                    <!-- Post Content -->
                    <div class="post-content mb-5">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    
                    <!-- Post Footer -->
                    <footer class="pt-4 border-top">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('posts.index') }}" class="btn btn-light">
                                <i class="bi bi-arrow-left"></i> Back to Posts
                            </a>
                            
                            @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Post
                            </a>
                            @endcan
                            
                            @can('publish', $post)
                                @if($post->status !== 'published')
                                <form action="{{ route('posts.publish', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-send"></i> Publish Post
                                    </button>
                                </form>
                                @endif
                            @endcan
                            
                            @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline ms-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                    <i class="bi bi-trash"></i> Delete Post
                                </button>
                            </form>
                            @endcan
                        </div>
                    </footer>
                </div>
            </article>
            
            <!-- Author Info Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">About the Author</h5>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $post->user->name }}</h6>
                            <p class="text-muted mb-1">{{ ucfirst($post->user->role) }}</p>
                            <small class="text-muted">Member since {{ $post->user->created_at->format('F Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection