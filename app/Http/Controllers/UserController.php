<?php



namespace App\Http\Controllers;

use App\Models\UserAccount;
use App\Models\Student;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = UserAccount::with(['profile', 'posts'])->latest()->paginate(10);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $degrees = Degree::all();
        return view('user.create', compact('degrees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'mname' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'lname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'contact' => ['required', 'digits:11'],
            'degree_id' => ['required', 'exists:degrees,id'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:user_accounts,username'],
            'email' => ['required', 'email', 'max:255', 'unique:user_accounts,email'],
            'role' => ['required', 'string', 'in:admin,teacher,student'],
        ], [
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 2 letters.',
            'fname.regex' => 'First name must contain letters only.',
            'mname.required' => 'Middle name is required.',
            'mname.regex' => 'Middle name must contain letters only.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'lname.regex' => 'Last name must contain letters only.',
            'contact.required' => 'Contact number is required.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
            'degree_id.required' => 'Degree is required.',
            'degree_id.exists' => 'Selected degree is invalid.',
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.unique' => 'Username already exists.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',
            'role.required' => 'Role is required.',
        ]);

        $user = UserAccount::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['role'] === 'student' ? 'student1234' : 'teacher1234'),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        // Create first login token for new user
        \App\Models\FirstLoginToken::create([
            'user_id' => $user->id,
            'used' => false,
        ]);

        // Create the student record
        Student::create([
            'fname' => $validated['fname'],
            'mname' => $validated['mname'],
            'lname' => $validated['lname'],
            'contact' => $validated['contact'],
            'degree_id' => $validated['degree_id'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('users.index')->with('success', 'User and Student created successfully.');
    }

    public function show(string $id)
    {
        $user = UserAccount::findOrFail($id);

        return view('user.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = UserAccount::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = UserAccount::findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', Rule::unique('user_accounts', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('user_accounts', 'email')->ignore($user->id)],
            'role' => ['required', 'string', 'in:admin,teacher,student'],
        ], [
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.unique' => 'Username already exists.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',
            'role.required' => 'Role is required.',
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user->id)->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = UserAccount::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
