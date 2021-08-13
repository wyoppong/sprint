<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Permission as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $guard_name = 'web';
    
    // Relationships
    /**
     * @return mixed
     */
    public function parent()
    {
        return $this -> belongsTo(__CLASS__, 'parent_id') -> with('parent');
    }

    /**
     * @return mixed
     */
    public function children()
    {
        return $this -> hasMany(__CLASS__, 'parent_id') -> with('children');
    }


    // scopes
    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsMaster($query)
    {
        return $query -> whereDoesntHave('parent')
            ->whereHas('children');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query -> whereHas('children');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsChild($query)
    {
        return $query -> whereHas('parent');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeSingular($query)
    {
        return $query -> whereNull('parent_id')
            ->whereDoesntHave('children');
    }

}
