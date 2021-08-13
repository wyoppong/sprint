<?php

namespace App\Models\Auth;

use Illuminate\Support\Str;
use App\Enums\UserTypeEnum;
use function Safe\preg_match_all;
use Spatie\Permission\Traits\HasRoles;
use App\Sprint\Support\Traits\HasPhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'password',
        'active',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => UserTypeEnum::class,
        'active' => 'boolean',
        'to_be_logged_out' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

        /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'photo_url',
    //     'initials'
    // ];

    /**
     * @var string[]
     */
    // protected $with = ['roles', 'permissions', 'stakeholder'];

    public function photoColumn()
    {
        return 'profile_photo_path';    
    }

    public function photoColumnObject()
    {
        return $this -> profile_photo_path;    
    }

    /**
     * Return true or false if the user can impersonate an other user.
     *
     * @param void
     * @return  bool
     */
    public function canImpersonate(): bool
    {
        return $this -> can('access.user.impersonate');
    }

    /**
     * Return true or false if the user can be impersonate.
     *
     * @param void
     * @return  bool
     */
    public function canBeImpersonated(): bool
    {
        return ! $this -> isSuperAdmin();
    }

    // scopes
        /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeOnlyDeactivated($query)
    {
        return $query -> whereActive(false);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeOnlyActive($query)
    {
        return $query -> whereActive(true);
    }

    // methods
    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this -> id === 1;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this -> hasAnyRole(
            config('sprint.access.role.super'),
            config('sprint.access.role.system'),
            config('sprint.access.role.admin')
        );
    }

    /**
     * @return bool
     */
    public function isSubAdmin()
    {
        return $this -> hasRole('sub-admin');
    }

    /**
     * @return mixed
     */
    public function canChangeEmail()
    {
        return config('sprint.access.user.change_email');
    }


    /**
     * @return mixed
     */
    public function hasAllAccess(): bool
    {
        return $this -> isSuperAdmin() && $this -> hasRole(config('sprint.access.role.super'));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this -> active;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this -> email_verified_at;
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this -> permissions -> pluck('description');
    }

        /**
     * @return string
     */
    public function getPermissionsLabelAttribute()
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

    /**
     * Get user's initials.
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        // $name = Str::ascii($this -> name, LocaleHelper::getLang());
        $name = Str::ascii($this -> name);
        preg_match_all('/(?<=\s|^)[a-zA-Z0-9]/i', $name, $initials);

        return implode('', $initials[0]);
    }

    /**
     * @return mixed
     */
    public function getAvatarAttribute()
    {
        return $this -> getAvatar();
    }

    /**
     * @return string
     */
    public function getRolesLabelAttribute()
    {
        if ($this -> isSuperAdmin()) {
            return 'All';
        }

        if (! $this->roles->count()) {
            return 'None';
        }

        return collect($this->getRoleNames())
            ->each(function ($role) {
                return ucwords($role);
            })
            ->implode('<br/>');
    }

    public function getPermissionArray()
    {
        return $this -> getAllPermissions() 
        -> mapWithKeys(function($permission) {
            return [$permission['name'] => true];
        });

    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
}
