<?php
if(! function_exists('user')){
    /**
     * @param null $driver
     * @return mixed
     */
    function user($driver = null)
    {
        if($driver){
            return app('auth')->guard($driver)->user(); //user('api')
        }

        return  app('auth')->user();
    }
}