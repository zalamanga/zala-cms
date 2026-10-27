<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->paginate(10)]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $user = User::create($this->validated($request));
        $this->audit($request, 'Tambah user', $user);

        return redirect()->route('admin.users.index')->with('status', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validated($request, $user));
        $this->audit($request, 'Update user', $user);

        return redirect()->route('admin.users.index')->with('status', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        abort_if($request->user()->is($user), 403, 'Tidak bisa menghapus akun sendiri.');

        $this->audit($request, 'Hapus user', $user);
        $user->delete();

        return back()->with('status', 'User berhasil dihapus.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user)],
            'role' => ['required', Rule::in(['admin', 'editor'])],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];

        $data = $request->validate($rules);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }

    private function audit(Request $request, string $action, User $user): void
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => "{$action}: {$user->email}",
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'ip_address' => $request->ip(),
        ]);
    }
}
