@extends('format.layout')

@section('title', 'User Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">User Details</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Review the selected user account.</p>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15); max-width: 860px;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: #f0f5eb; display: flex; align-items: center; justify-content: center; color: #ABC28B; font-weight: 700; font-size: 2rem;">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <div>
                <h2 style="margin: 0; color: #112C01;">{{ $user->username }}</h2>
                <p style="margin-top: 0.5rem; color: #6b7280;">{{ $user->email }}</p>
            </div>
        </div>

        <div style="display: grid; gap: 1rem;">
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Username</strong>
                <span style="color: #374151;">{{ $user->username }}</span>
            </div>
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Email</strong>
                <span style="color: #374151;">{{ $user->email }}</span>
            </div>
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Role</strong>
                <span style="color: #374151;">{{ ucfirst($user->role) }}</span>
            </div>
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Profile Status</strong>
                <span style="color: #374151;">{{ $user->profile ? 'This user already has a profile.' : 'This user does not have a profile yet.' }}</span>
            </div>
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Posts Created</strong>
                <span style="color: #374151;">{{ $user->posts->count() }}</span>
            </div>
            <div style="padding: 1rem; background: #f0f5eb; border-radius: 10px;">
                <strong style="display: block; color: #ABC28B; margin-bottom: 0.35rem;">Joined</strong>
                <span style="color: #374151;">{{ $user->created_at?->format('F d, Y h:i A') }}</span>
            </div>
        </div>

        @if ($user->posts->isNotEmpty())
            <div style="margin-top: 2rem;">
                <h3 style="color: #ABC28B; margin-bottom: 1rem;">Recent Posts</h3>
                <div style="display: grid; gap: 0.75rem;">
                    @foreach ($user->posts->take(3) as $post)
                        <div style="padding: 1rem; background: #fff7fb; border: 1px solid #fbcfe8; border-radius: 10px;">
                            <strong style="display: block; color: #4b1f3a;">{{ $post->title }}</strong>
                            <span style="color: #6b7280;">{{ Str::limit($post->content, 100) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('users.edit', $user->id) }}" style="padding: 0.75rem 1.5rem; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none;">Edit</a>
            <a href="{{ route('users.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Back</a>
        </div>
    </div>
@endsection
