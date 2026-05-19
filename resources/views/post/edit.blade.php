@extends('format.layout')

@section('title', 'Edit Post')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Edit Post</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Update the post content and author.</p>
    </div>

    @if ($errors->any())
        <div style="padding: 1rem; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #991b1b; margin-bottom: 1.5rem;">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="max-width: 760px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label for="user_id" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Author <span style="color: #ef4444;">*</span></label>
                <select name="user_id" id="user_id" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="title" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Title <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="content" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Content <span style="color: #ef4444;">*</span></label>
                <textarea name="content" id="content" rows="8" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px; resize: vertical;">{{ old('content', $post->content) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Update Post</button>
                <a href="{{ route('posts.show', $post->id) }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
