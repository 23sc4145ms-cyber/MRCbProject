@extends('format.layout')

@section('title', 'Users')

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Users</h1>
            <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Manage user accounts connected to profiles and posts.</p>
        </div>
        <a href="{{ route('users.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01; border-radius: 8px; font-size: 1rem; font-weight: 600; text-decoration: none; display: inline-block;">+ New User</a>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f0f5eb; border-bottom: 2px solid #ABC28B;">
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">#</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Username</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Email</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Profile</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Posts</th>
                    <th style="padding: 1rem; text-align: center; color: #ABC28B;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr style="border-bottom: 1px solid #e0e7d8; transition: background-color 0.2s ease; {{ $loop->even ? 'background-color: #f0f5eb;' : 'background-color: #fff;' }}" onmouseover="this.style.backgroundColor='#f0f5eb';" onmouseout="this.style.backgroundColor='{{ $loop->even ? '#f0f5eb' : '#fff' }}'">
                        <td style="padding: 1rem; color: #677C56; font-weight: 600;">{{ $users->firstItem() + $loop->index }}</td>
                        <td style="padding: 1rem; color: #333;">{{ $user->username }}</td>
                        <td style="padding: 1rem; color: #333;">{{ $user->email }}</td>
                        <td style="padding: 1rem; color: #666;">{{ $user->profile ? 'Created' : 'Not yet' }}</td>
                        <td style="padding: 1rem; color: #666;">{{ $user->posts ? $user->posts->count() : 0 }}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <div class="action-group">
                                <a href="{{ route('users.show', $user->id) }}" class="action-btn action-btn-sm action-btn-view" title="View">View</a>
                                <a href="{{ route('users.edit', $user->id) }}" class="action-btn action-btn-sm action-btn-edit" title="Edit">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this user? Related profile and posts may also be removed.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-sm action-btn-delete" title="Delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #999;">No users yet. Create one to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
