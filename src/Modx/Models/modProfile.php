<?php

namespace Modx\Models;

use Illuminate\Database\Eloquent\Model;

class modProfile extends Model
{
    
    protected $table = 'user_attributes';

    public $timestamps = false;

    function __construct() {
        $this->connection = config('modx.connection');
    }

    public function user()
    {
        return $this->belongsTo(modUser::class, 'id', 'internalKey');
    }
}
