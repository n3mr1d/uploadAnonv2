<?php

namespace Illuminate\Support\Facades;

interface Auth
{
    /**
     * @return \App\Models\User|false
     */
    public static function loginUsingId(mixed $id, bool $remember = false);

    /**
     * @return \App\Models\User|false
     */
    public static function onceUsingId(mixed $id);

    /**
     * @return \App\Models\User|null
     */
    public static function getUser();

    /**
     * @return \App\Models\User
     */
    public static function authenticate();

    /**
     * @return \App\Models\User|null
     */
    public static function user();

    /**
     * @return \App\Models\User|null
     */
    public static function logoutOtherDevices(string $password);

    /**
     * @return \App\Models\User
     */
    public static function getLastAttempted();
}