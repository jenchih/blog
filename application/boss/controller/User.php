<?php
namespace app\boss\controller;
use think\Db;

class User extends Base
{
	public function loginvalid()
	{
		$return['code']    = 400;
		$return['message'] = '账号或密码错误';
		$username          = input('username','');
		$pwd               = input('password','');

		$res = Db::table('admin')->where('username', $username)->find();
		if( empty($res) ) return $return;

		if( $this->check_password($res['password'],config('pwd_cfg').$pwd) )
		{
			$return['code']    = 200;
			$return['message'] = '登陆成功';
			session('username', $username);
		}
		return $return;
	}

	public function logout()
	{
		\think\Session::clear();
		return ['code'=>200,'message'=>'success'];
	}

	private function setSession($username)
	{
		session('username', $username);
	}

	private function check_password($hash, $password) 
	{ 
		$full_salt = substr($hash, 0, 29); 
		$new_hash = crypt($password, $full_salt); 
		return ($hash === $new_hash); 
	} 
}
