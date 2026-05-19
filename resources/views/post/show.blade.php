@extends('format.layout')

@section('title', 'Post Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Post Details</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Review the full post content.</p>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <article style="max-width: 860px; background: #fff; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.12);">
        <p style="color: #9f1239; font-weight: 600; margin-bottom: 0.75rem;">Author: {{ $post->user->name ?? 'Unknown User' }}</p>
        <h2 style="margin: 0; color: #4b1f3a; font-size: 2rem;">{{ $post->title }}</h2>
        <p style="margin-top: 0.75rem; color: #6b7280;">Published {{ $post->created_at?->format('F d, Y h:i A') }}</p>
        <div style="margin-top: 1.5rem; padding: 1.5rem; background: #fdf2f8; border-radius: 12px; color: #374151; line-height: 1.7; white-space: pre-line;">
            {{ $post->content }}
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('posts.edit', $post->id) }}" style="padding: 0.75rem 1.5rem; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none;">Edit</a>
            <a href="{{ route('posts.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Back</a>
        </div>
    </article>
@endsection
