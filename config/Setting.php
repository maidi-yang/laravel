<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/24
 * Time: 17:29
 */

namespace App;


use Illuminate\Foundation\Auth\User;

/**
 * Class Setting
 * @package App
 */
class Setting
{
    protected $user;
    protected $allowed = ['city','bio'];
    /**
     * Setting constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function merge(array $attributes)
    {
        $settings = array_merge($this->user->settings,array_only($attributes,$this->allowed));
        return $this->user->update(['settings' => $settings]);
    }
}