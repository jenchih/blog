<?php
namespace app\boss\model;
use think\Model;
use think\Db;
class User extends Model
{
	
	private static $algo = '$2a'; 
	private static $cost = '$10'; 

	private static function unique_salt() 
	{ 
		return substr(sha1(mt_rand()),0,22); 
	}

	public function hash($password) 
	{ 
		return crypt($password, 
			self::$algo . 
			self::$cost . 
			'$'. self::unique_salt()); 
	}
	public function check_password($hash, $password) 
	{ 
		$full_salt = substr($hash, 0, 29); 
		$new_hash = crypt($password, $full_salt); 
		return ($hash === $new_hash); 
	} 
}