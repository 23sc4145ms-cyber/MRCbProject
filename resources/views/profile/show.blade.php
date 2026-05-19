@extends('format.layout')

@section('title', 'Profile Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Profile Details</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Review the selected profile information.</p>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15); max-width: 800px;">
        <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
            <div style="width: 90px; height: 90px; border-radius: 50%; background: #fce7f3; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #ec4899; font-weight: 700; font-size: 2rem;">
                @if ($profile->image_url)
                    <img src="{{ $profile->image_url }}" alt="{{ $profile->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ strtoupper(substr($profile->user->name ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div>
                <h2 style="margin: 0; color: #4b1f3a;">{{ $profile->user->name ?? 'No User' }}</h2>
                <p style="margin-top: 0.5rem; color: #6b7280;">{{ $profile->user->email ?? 'No email available' }}</p>
            </div>
        </div>

        <div style="display: grid; gap: 1rem;">
            <div style="padding: 1rem; background: #fdf2f8; border-radius: 10px;">
                <strong style="display: block; color: #ec4899; margin-bottom: 0.35rem;">Image URL</strong>
                <span style="color: #374151;">{{ $profile->image_url ?: 'No image URL provided.' }}</span>
            </div>
            <div style="padding: 1rem; background: #fdf2f8; border-radius: 10px;">
                <strong style="display: block; color: #ec4899; margin-bottom: 0.35rem;">Bio</strong>
                <span style="color: #374151;">{{ $profile->bio ?: 'No bio provided.' }}</span>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('profiles.edit', $profile->id) }}" style="padding: 0.75rem 1.5rem; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none;">Edit</a>
            <a href="{{ route('profiles.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Back</a>
        </div>
    </div>
@endsection
