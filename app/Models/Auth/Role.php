<?php

namespace App\Models\Auth;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guard_name = 'web';

    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
    ];

    // attributes
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setNameAttribute($name)
    {
        $this -> attributes['name'] = strtolower($name);
    }

    /**
     * @return string
     */
    public function getPermissionsLabelAttribute(): string
    {
        if ($this -> isSuperAdmin()) {
            return 'All';
        }

        if (! $this -> permissions -> count()) {
            return 'None';
        }

        return collect($this -> getPermissionDescriptions())
            ->implode('<br/>');
    }

    // methods
    /**
     * @return mixed
     */
    public function isSuperAdmin(): bool
    {
        return strtolower($this -> name) === config('sprint.access.role.super');
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this-> permissions -> pluck('description');
    }
    
}
