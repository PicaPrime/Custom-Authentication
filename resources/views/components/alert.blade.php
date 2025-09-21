<!-- ============================================= -->
<!-- resources/views/components/alert.blade.php -->
<!-- ============================================= -->
@props(['type' => 'info', 'dismissible' => true])

@php
$iconMap = [
    'success' => 'bi-check-circle',
    'danger' => 'bi-exclamation-circle',
    'warning' => 'bi-exclamation-triangle',
    'info' => 'bi-info-circle',
];
$icon = $iconMap[$type] ?? 'bi-info-circle';
@endphp

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    <i class="bi {{ $icon }} me-2"></i>
    {{ $slot }}
    @if($dismissible)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

<!-- ============================================= -->
<!-- resources/views/errors/403.blade.php -->
<!-- ============================================= -->
@extends('layouts.app')

@section('title', 'Forbidden')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto text-center">
            <div class="card">
                <div class="card-body py-5">
                    <i class="bi bi-shield-exclamation text-danger" style="font-size: 4rem;"></i>
                    <h1 class="h2 mt-4 mb-3">Access Forbidden</h1>
                    <p class="text-muted mb-4">
                        You don't have permission to access this resource. 
                        This action requires higher privileges or ownership of the content.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">
                            <i class="bi bi-house"></i> Go to Posts
                        </a>
                        <button onclick="history.back()" class="btn btn-light">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection