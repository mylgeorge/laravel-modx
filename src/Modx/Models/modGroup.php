<?php

namespace Modx\Models;

use Illuminate\Database\Eloquent\Model;

class modGroup extends Model
{

    protected $table= 'membergroup_names';

    function __construct() {
        $this->connection = config('modx.connection');
    }
    
    public function users()
    {
        return $this->belongsToMany(modUser::class, 'member_groups', 'user_group', 'member');
    }
}
