<?php
/*
 * This file is part of the Laravel-Modx package.
 *
 * (c) Giorgos Mylonas <mylgeorge@gmail.com>
 *
 */

namespace Modx;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class ModxHasher implements HasherContract
{

    public function info($hashedValue){
        return [];
    }

    public function make($value, array $options = [])
    {
        return $this->get_pbkdf2($value, $options['salt']);
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    public function check($value, $hashedValue, array $options = [])
    {
        $hashedPassword = $this->get_pbkdf2($value, $options['salt']);
        return hash_equals($hashedPassword, $hashedValue);
    }

    public function get_pbkdf2($password, $salt = '')
    {
        // modx default options
        // todo maybe get options from database 
        return base64_encode(hash_pbkdf2('sha256', $password, $salt, 1000, 32, true));
    }

}