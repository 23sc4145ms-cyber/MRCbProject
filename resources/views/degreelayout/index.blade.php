@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Degrees</h2>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('degrees.create') }}" class="btn btn-primary">Add New Degree</a>
            </div>

            @if($degrees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Degree Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($degrees as $degree)
                                <tr>
                                    <td>{{ $degree->id }}</td>
                                    <td>{{ $degree->Degree }}</td>
                                    <td>
                                        <a href="{{ route('degrees.show', $degree->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('degrees.edit', $degree->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('degrees.destroy', $degree->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No degrees found. <a href="{{ route('degrees.create') }}">Create one now</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
