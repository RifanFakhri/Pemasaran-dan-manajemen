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
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        if(strlen($this->search) > 2) {
            $this->suggestions = User::where('name', 'like', '%'.$this->search.'%')
                ->limit(5)
                ->get(['id', 'name']);
        } else {
            $this->suggestions = [];
        }
    }

    public function selectUser($id)
    {
        $user = User::find($id);
        $this->search = $user->name;
        $this->suggestions = [];
    }

    public function edit($id)
    {
        // Redirect to edit page or show modal
        return redirect()->route('admin.users.edit', $id);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('username', 'like', '%'.$this->search.'%')
                      ->orWhere('role', 'like', '%'.$this->search.'%');
            })
            ->select('id', 'name', 'username', 'role')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.user-table', [
            'users' => $users
        ])->layout('layouts.admin');
    }
}