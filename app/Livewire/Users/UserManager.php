<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    // Create Modal state
    public bool $showCreateModal = false;
    public string $name = '';
    public string $email = '';
    public string $role = 'librarian';
    public string $password = '';
    public string $password_confirmation = '';

    // Delete Modal state
    public bool $showDeleteModal = false;
    public ?int $selectedUserId = null;
    public string $selectedUserName = '';

    // Reset Password Modal state
    public bool $showResetPasswordModal = false;
    public string $newPassword = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'email', 'role', 'password', 'password_confirmation']);
        $this->role = 'librarian';
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function createUser(): void
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang diizinkan menambahkan akun.');
        }

        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'     => ['required', 'string', 'in:admin,librarian'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'role', 'password', 'password_confirmation']);

        session()->flash('message', 'Akun ' . ($validated['role'] === 'admin' ? 'Admin' : 'Pustakawan') . ' berhasil dibuat!');
    }

    public function confirmDelete(int $id): void
    {
        if ($id === Auth::id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang terhubung.');
            return;
        }

        $user = User::findOrFail($id);
        $this->selectedUserId = $user->id;
        $this->selectedUserName = $user->name;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang diizinkan menghapus akun.');
        }

        if ($this->selectedUserId === Auth::id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            $this->showDeleteModal = false;
            return;
        }

        $user = User::find($this->selectedUserId);
        if ($user) {
            $deletedName = $user->name;
            $user->delete();
            session()->flash('message', "Akun \"{$deletedName}\" berhasil dihapus dari sistem.");
        }

        $this->showDeleteModal = false;
        $this->reset(['selectedUserId', 'selectedUserName']);
    }

    public function openResetPasswordModal(int $id): void
    {
        $user = User::findOrFail($id);
        $this->selectedUserId = $user->id;
        $this->selectedUserName = $user->name;
        $this->newPassword = '';
        $this->resetValidation();
        $this->showResetPasswordModal = true;
    }

    public function resetPassword(): void
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang diizinkan mereset kata sandi.');
        }

        $this->validate([
            'newPassword' => ['required', 'string', 'min:8'],
        ], [
            'newPassword.required' => 'Kata sandi baru wajib diisi.',
            'newPassword.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        $user = User::find($this->selectedUserId);
        if ($user) {
            $user->update([
                'password' => Hash::make($this->newPassword),
            ]);
            session()->flash('message', "Kata sandi untuk \"{$user->name}\" berhasil diperbarui!");
        }

        $this->showResetPasswordModal = false;
        $this->reset(['selectedUserId', 'selectedUserName', 'newPassword']);
    }

    public function render()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $query = User::query();

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter !== '') {
            $query->where('role', $this->roleFilter);
        }

        $users = $query->orderBy('name', 'asc')->paginate(10);

        return view('livewire.users.user-manager', compact('users'))
            ->layout('layouts.app');
    }
}
