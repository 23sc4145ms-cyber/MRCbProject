@extends('format.layout')

@section('title')
    Student Details
@endsection

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Student Details</h1>
            <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">View and manage student information</p>
        </div>
        <a href="/students/create" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01; text-decoration: none; border-radius: 8px; font-weight: 600; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.25); display: inline-block;" onmouseover="this.style.boxShadow='0 8px 12px rgba(171, 194, 139, 0.4)'" onmouseout="this.style.boxShadow='0 4px 6px rgba(171, 194, 139, 0.25)'">+ Add Student</a>
    </div>
    
    @if(session('success'))
    <div style="padding: 1rem; background-color: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 4px; margin-bottom: 1.5rem; color: #677C56;">
        {{ session('success') }}
    </div>
    @endif
    
    <table style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
        <thead>
            <tr style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01;">
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">#</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Name</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Email</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Contacts</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr style="border-bottom: 1px solid #e0e7d8; transition: background-color 0.2s ease; {{ $loop->even ? 'background-color: #f0f5eb;' : 'background-color: #fff;' }}" 
                onmouseover="this.style.backgroundColor='#f0f5eb';" 
                onmouseout="this.style.backgroundColor='{{ $loop->even ? '#f0f5eb' : '#fff' }}';">
                
                <td style="padding: 1rem; color: #831843; font-weight: 600;">{{ $loop->iteration }}</td>
                <td style="padding: 1rem; color: #333;">{{ $student['fname'] }} {{ $student['mname'] }} {{ $student['lname'] }}</td>
                <td style="padding: 1rem; color: #666;">{{ $student->user->email }}</td>
                <td style="padding: 1rem; color: #666;">{{ $student['contact'] }}</td>

                <td style="padding: 1rem;">
                    <div class="action-group" style="justify-content: flex-start;">
                        <a href="/students/{{ $student['id'] }}" class="action-btn action-btn-sm action-btn-view" title="View">View</a>
                        <a href="/students/{{ $student['id'] }}/edit" class="action-btn action-btn-sm action-btn-edit" title="Edit">Edit</a>
                        <form id="delete-form-{{ $student['id'] }}" action="/students/{{ $student['id'] }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openModal({{ $student['id'] }})" class="action-btn action-btn-sm action-btn-delete" title="Delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:999;">
        <div style="background:#fff; padding:30px; border-radius:12px; text-align:center; width:300px;">
            <h2 style="color:#ABC28B;">Confirm Delete</h2>
            <p style="margin:15px 0; color:#555;">Are you sure you want to delete this student?</p>

            <div style="margin-top:20px;">
                <button onclick="confirmDelete()" style="padding:8px 15px; background:#ef4444; color:#fff; border:none; border-radius:6px; margin-right:10px;">
                    Yes
                </button>

                <button onclick="closeModal()" style="padding:8px 15px; background:#ccc; border:none; border-radius:6px;">
                    No
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function openModal(id) {
            deleteId = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            deleteId = null;
        }

        function confirmDelete() {
            if (deleteId) {
                $.ajax({
                    url: "/students/" + deleteId,
                    type: "DELETE",
                    success: function(response) {
                        if (response.success) {
                            alert("Student deleted successfully!");
                            window.location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert("Error deleting student: " + xhr.responseText);
                        closeModal();
                    }
                });
            }
        }
    </script>
@endsection
