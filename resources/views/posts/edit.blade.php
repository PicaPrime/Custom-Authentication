<!-- ============================================= -->
<!-- resources/views/posts/edit.blade.php -->
<!-- ============================================= -->
@extends('layouts.app2')

@section('title', 'Edit Post')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('posts.show', $post) }}">{{ Str::limit($post->title, 30) }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>

                <!-- Page Header -->
                <div class="mb-4">
                    <h1 class="h2">Edit Post</h1>
                    <p class="text-muted">Update your post content and settings</p>
                </div>

                <!-- Post Info Card -->
                <div class="card mb-4 bg-light">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-muted">Author</small>
                                <div class="fw-semibold">
                                    <i class="bi bi-person-circle"></i> {{ $post->user->name }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Created</small>
                                <div class="fw-semibold">{{ $post->created_at->format('M d, Y g:i A') }}</div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Last Updated</small>
                                <div class="fw-semibold">{{ $post->updated_at->format('M d, Y g:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('posts.update', $post) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="form-label">Post Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="12"
                                    required>{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>
                                        📝 Draft
                                    </option>
                                    <option value="published"
                                        {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>
                                        🚀 Published
                                    </option>
                                    <option value="archived"
                                        {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>
                                        📦 Archived
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($post->published_at)
                                    <small class="form-text text-muted">
                                        Originally published on {{ $post->published_at->format('F j, Y \a\t g:i A') }}
                                    </small>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Update Post
                                </button>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-light">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </a>

                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="ms-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                            <i class="bi bi-trash"></i> Delete Post
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
