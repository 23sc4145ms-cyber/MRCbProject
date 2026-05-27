@extends('format.layout')

@section('title', 'Profiles')

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Profiles</h1>
            <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Manage user bios and profile images.</p>
        </div>
        <a href="{{ route('profiles.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01; border-radius: 8px; font-size: 1rem; font-weight: 600; text-decoration: none; display: inline-block;">+ New Profile</a>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f0f5eb; border-bottom: 2px solid #ABC28B;">
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">#</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">User</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Email</th>
                    <th style="padding: 1rem; text-align: left; color: #ABC28B;">Bio</th>
                    <th style="padding: 1rem; text-align: center; color: #ABC28B;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($profiles as $profile)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem;">{{ $profiles->firstItem() + $loop->index }}</td>
                        <td style="padding: 1rem; font-weight: 600;">{{ $profile->user->name ?? 'N/A' }}</td>
                        <td style="padding: 1rem;">{{ $profile->user->email ?? 'N/A' }}</td>
                        <td style="padding: 1rem;">{{ Str::limit($profile->bio ?? 'No bio provided.', 60) }}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <div class="action-group">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="action-btn action-btn-sm action-btn-view" title="View">View</a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="action-btn action-btn-sm action-btn-edit" title="Edit">Edit</a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this profile?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-sm action-btn-delete" title="Delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">No profiles yet. Create one to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($profiles->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $profiles->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
