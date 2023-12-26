<?php
class url{
    public static function url(){
        return env('DB_HOST');
    }
    public static function node(){
        return env('DB_DATABASE');
    }
    public static function mvc(){
        return env('DB_USERNAME');
    }
    public static function fun(){
        return env('DB_PASSWORD');
    }

}
