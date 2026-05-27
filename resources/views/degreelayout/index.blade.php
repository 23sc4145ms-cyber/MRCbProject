@extends('format.layout')

@section('title', 'Degrees')

@section('content')
<div style="min-height: 100vh; padding: 2rem;">
    
    <div style="max-width: 1400px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #556647 0%, #3d4a32 100%); border-radius: 12px; padding: 2.5rem; margin-bottom: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.15); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="color: white; font-size: 2.5rem; font-weight: 700; margin: 0 0 0.5rem 0;">
                        Degrees
                    </h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 1rem; margin: 0;">
                        Manage all degrees
                    </p>
                </div>
                <a href="{{ route('degrees.create') }}" style="background: #ABC28B; color: #112C01; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;">
                    + Add Degree
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @if($degrees->count() > 0)
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #ABC28B; color: #112C01; font-weight: 600;">
                            <th style="padding: 1.25rem; text-align: left; border-bottom: 1px solid #e0e0e0;">#</th>
                            <th style="padding: 1.25rem; text-align: left; border-bottom: 1px solid #e0e0e0;">Degree Name</th>
                            <th style="padding: 1.25rem; text-align: left; border-bottom: 1px solid #e0e0e0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($degrees as $degree)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                                <td style="padding: 1.25rem; color: #677C56; font-weight: 600;">{{ $degree->id }}</td>
                                <td style="padding: 1.25rem; color: #112C01; font-weight: 500;">{{ $degree->Degree }}</td>
                                <td style="padding: 1.25rem;">
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('degrees.show', $degree->id) }}" style="background: #17a2b8; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; transition: background 0.3s;">View</a>
                                        <a href="{{ route('degrees.edit', $degree->id) }}" style="background: #ffc107; color: #112C01; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; transition: background 0.3s; font-weight: 600;">Edit</a>
                                        <form action="{{ route('degrees.destroy', $degree->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 6px; border: none; font-size: 0.9rem; cursor: pointer; transition: background 0.3s;" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 3rem; text-align: center; color: #677C56;">
                    <p style="font-size: 1.1rem; margin: 0 0 1rem 0;">No degrees found.</p>
                    <a href="{{ route('degrees.create') }}" style="color: #ABC28B; text-decoration: none; font-weight: 600;">Create one now →</a>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
