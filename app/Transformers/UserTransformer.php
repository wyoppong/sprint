<?php

namespace App\Transformers;

use App\Models\Auth\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
	public function transform(User $user)
	{
	    return [
	        'id'      => (int) $user -> id,
	        'name'   => $user -> name,
	        'username'   => $user -> username,
	        'email'   => $user -> email,
	        'active'   => $user -> active,
	        'initials'   => $user -> initials,
	    ];
	}
}