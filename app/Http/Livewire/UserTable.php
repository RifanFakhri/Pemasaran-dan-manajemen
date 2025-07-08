<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $suggestions = [];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function applySearch()
    {
        $this->suggestions = [];
        $this->resetPage(); // Reset halaman paginasi
    }

    public function edit($id)
    {
        session()->flash('message', 'Edit user ID: ' . $id);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('username', 'like', '%' . $this->search . '%')
                      ->orWhere('role', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'name', 'username', 'role')
            ->paginate(10);

        return view('livewire.admin.user-table', compact('users'));
    }
}
