@extends('format.layout')

@section('title')
    View Degree
@endsection

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Degree Information</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">View degree program details</p>
    </div>

    <div style="max-width: 600px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Degree Name</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #333; font-size: 1.1rem;">{{ $degree->Degree }}</p>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Date Created</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #666;">{{ $degree->created_at ? $degree->created_at->format('M d, Y H:i') : 'N/A' }}</p>
        </div>

        <div class="action-group" style="justify-content: flex-start;">
            <a href="{{ route('degrees.edit', $degree->id) }}" class="action-btn action-btn-edit">Edit</a>
            <a href="{{ route('degrees.index') }}" class="action-btn action-btn-back">Back</a>
        </div>
    </div>

@endsection
