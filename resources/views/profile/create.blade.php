@extends('format.layout')

@section('title', 'Create Profile')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Create Profile</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Add a profile for an existing user.</p>
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
        <form action="{{ route('profiles.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="user_id" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">User <span style="color: #ef4444;">*</span></label>
                <select name="user_id" id="user_id" required style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @if ($users->isEmpty())
                    <p style="margin-top: 0.5rem; color: #b45309;">No available users without a profile.</p>
                @endif
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="image_url" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Image URL</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/photo.jpg" style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="bio" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Bio</label>
                <textarea name="bio" id="bio" rows="6" placeholder="Tell us about the user..." style="width: 100%; padding: 0.75rem; border: 2px solid #fce7f3; border-radius: 8px; resize: vertical;">{{ old('bio') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Create Profile</button>
                <a href="{{ route('profiles.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
