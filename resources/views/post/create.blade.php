@extends('format.layout')

@section('title', 'Create Post')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Create Post</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Write a new post for a selected user.</p>
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
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="user_id" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Author <span style="color: #ef4444;">*</span></label>
                <select name="user_id" id="user_id" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="title" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Title <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Enter post title" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="content" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Content <span style="color: #ef4444;">*</span></label>
                <textarea name="content" id="content" rows="8" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px; resize: vertical;">{{ old('content') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Create Post</button>
                <a href="{{ route('posts.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
