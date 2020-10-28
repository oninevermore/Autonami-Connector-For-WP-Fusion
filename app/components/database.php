<?php

namespace App\Components;

use App\Vendors\Medoo;

class Database {
    static $conn;
    
    public static function set_connection(){
        if(!isset(self::$conn)){
            self::$conn = new Medoo([
                'database_type' => 'mysql',
                'database_name' => DB_Name,
                'server' => DB_SERVER_NAME,
                'username' => DB_USERNAME,
                'password' => DB_PASSWORD
            ]);
        }
    }
    
    public static function insert($table, $datas){
        self::set_connection();
        self::$conn->insert($table, $datas);
        return self::$conn->id();
    }
    
    public static function update($table, $data, $where = null){
        self::set_connection();
        self::$conn->update($table, $data, $where);
        return self::$conn->id();
    }
    
    public static function delete($table, $where){
        self::set_connection();
        self::$conn->delete($table, $where);
    }
    
    public static function has($table, $join, $where = null){
        self::set_connection();
        return self::$conn->has($table, $join, $where);
    }
    
    public static function select($table, $join, $columns = null, $where = null){
        self::set_connection();
        return self::$conn->select($table, $join, $columns, $where);
    }
    
    public static function get($table, $join, $columns = null, $where = null){
        self::set_connection();
        return self::$conn->get($table, $join, $columns, $where);
    }
    
    public static function query($query, $map = []){
        self::set_connection();
        return self::$conn->query($query, $map);
    }
    
    public static function debug(){
        self::set_connection();
        return self::$conn->debug();
    }
    
    public static function error(){
        self::set_connection();
        return self::$conn->error();
    }
    
    public static function last(){
        self::set_connection();
        return self::$conn->last();
    }
}