<!-- ============================================= -->
<!-- resources/views/posts/create.blade.php -->
<!-- ============================================= -->

@extends('layouts.app2')

@section('title', 'Create Post')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                        <li class="breadcrumb-item active">Create New Post</li>
                    </ol>
                </nav>

                <!-- Page Header -->
                <div class="mb-4">
                    <h1 class="h2">Create New Post</h1>
                    <p class="text-muted">Share your thoughts with the world</p>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="form-label">Post Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Enter an engaging title..." required autofocus>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Make it catchy and descriptive</small>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="12"
                                    placeholder="Write your post content here..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">You can use Markdown for formatting</small>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                        📝 Draft - Save for later
                                    </option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        🚀 Published - Share with everyone
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">You can always change this later</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="save" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Create Post
                                </button>
                                <button type="submit" name="action" value="save_and_view" class="btn btn-success">
                                    <i class="bi bi-eye"></i> Create & View
                                </button>
                                <a href="{{ route('posts.index') }}" class="btn btn-light">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card mt-4 border-info border-opacity-25">
                    <div class="card-body">
                        <h6 class="card-title text-info">
                            <i class="bi bi-lightbulb"></i> Writing Tips
                        </h6>
                        <ul class="mb-0 small">
                            <li>Use clear, descriptive titles that grab attention</li>
                            <li>Break your content into paragraphs for better readability</li>
                            <li>You can save as draft and publish when ready</li>
                            <li>Preview your post before publishing to check formatting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
