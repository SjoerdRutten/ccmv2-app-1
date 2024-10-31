<?php

namespace Sellvation\CCMV2\Users\Livewire\Users;

use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\Users\Models\User;

class Overview extends Component
{
    #[Url]
    public string $q = '';

    #[Url]
    public string $is_active = '1';

    public function getUsers()
    {
        return User::query()
            ->when(! empty($this->q), function ($query) {
                $query->where('name', 'like', '%'.$this->q.'%')
                    ->orWhere('email', 'like', '%'.$this->q.'%');
            })
            ->when($this->is_active === '1', function ($query) {
                $query->where('is_active', '>', 0)
                    ->where(
                        function ($query) {
                            $query->whereNull('expiration_date')
                                ->orWhereDate('expiration_date', '>=', now());
                        }
                    );
            })
            ->when($this->is_active === '0', function ($query) {
                $query->where('is_active', 0)
                    ->orWhereDate('expiration_date', '<', now());
            })
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('user::livewire.users.overview');
    }
}
