@extends('format.layout')

@section('title', 'Posts')

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Posts</h1>
            <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Manage user-authored posts and content.</p>
        </div>
        <a href="{{ route('posts.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01; border-radius: 8px; font-size: 1rem; font-weight: 600; text-decoration: none; display: inline-block;">+ New Post</a>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; gap: 1.25rem;">
        @forelse ($posts as $post)
            <div style="background: #fff; padding: 1.5rem; border-radius: 14px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.12);">
                <div style="display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap; align-items: flex-start;">
                    <div>
                        <h2 style="margin: 0; color: #112C01;">{{ $post->title }}</h2>
                        <p style="margin-top: 0.5rem; color: #677C56;">By {{ $post->user->name ?? 'Unknown User' }} • {{ $post->created_at?->format('M d, Y') }}</p>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('posts.show', $post->id) }}" title="View" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; text-decoration: none; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">👁️</a>
                        <a href="{{ route('posts.edit', $post->id) }}" title="Edit" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; text-decoration: none; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">✏️</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">🗑️</button>
                        </form>
                    </div>
                </div>
                <p style="margin-top: 1rem; color: #677C56; line-height: 1.6;">{{ Str::limit($post->content, 180) }}</p>
            </div>
        @empty
            <div style="background: #fff; padding: 2rem; border-radius: 14px; text-align: center; color: #6b7280;">
                No posts yet. Create one to get started.
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
