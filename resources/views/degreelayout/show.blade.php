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

        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('degrees.edit', $degree->id) }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.25); text-decoration: none; display: inline-block;" onmouseover="this.style.boxShadow='0 8px 12px rgba(245, 158, 11, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(245, 158, 11, 0.25)';">Edit</a>
            <a href="{{ route('degrees.index') }}" style="padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; display: inline-block;" onmouseover="this.style.backgroundColor='#d1d5db';" onmouseout="this.style.backgroundColor='#e5e7eb';">Back</a>
        </div>
    </div>

@endsection
