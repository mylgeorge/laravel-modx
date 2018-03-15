<?php

namespace Modx\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class modUser extends Authenticatable
{

    protected $table = 'users';

    public $timestamps = false;
    
    function __construct() {
        $this->connection = config('modx.connection');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remote_data', 'cachepwd', 'class_key', 'remote_key', 'remote_data', 'hash_class', 'salt', 'primary_group', 'session_stale'
    ];

    public function getRememberTokenName()
    {
        return 'remote_key';
    }

    public function groups()
    {
        return $this->belongsToMany(modGroup::class, 'member_groups', 'member', 'user_group');
    }

    public function profile()
    {
        return $this->hasOne(modProfile::class, 'internalkey', 'id');
    }

    public function isActive()
    {
        return $this->active;
    }

    public function isBlocked()
    {
        return $this->blocked
            || ($this->blockeduntil > 0 && $this->blockeduntil >= time())
            || ($this->blockedafter > 0 && $this->blockedafter <= time());
    }

    public function updateProfile()
    {
        $this->profile->logincount++;
        $this->profile->lastlogin = $this->profile->thislogin;
        $this->profile->thislogin = time();
        $this->profile->save();
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->profile->email;
    }

    public function routeNotificationForMail()
    {
        return $this->getEmailForPasswordReset();
    }

    public function isMember($groups, $matchAll = false)
    {
        $groupNames = array();
        $isMember = false;

        foreach ($this->groups->toArray() as $group) $groupNames[] = $group['name'];
        if ($groupNames) {
            if (is_array($groups)) {
                if ($matchAll) {
                    $matches = array_diff($groups, $groupNames);
                    $isMember = empty($matches);
                } else {
                    $matches = array_intersect($groups, $groupNames);
                    $isMember = !empty($matches);
                }
            } else {
                $isMember = (array_search($groups, $groupNames) !== false);
            }
        }
        return $isMember;
    }

}
