<?php
namespace app\boss\controller;
use think\Db;

class User extends Base
{
	public function loginvalid()
	{
		$this->code    = 400;
		$this->message = '账号或密码错误';
		$username      = input('username','');
		$pwd           = input('password','');

		$res = Db::table('admin')->where('username', $username)->find();
		if( empty($res) ) $this->returnData();

		if( $this->check_password($res['password'],config('pwd_cfg').$pwd) )
		{
			$this->code    = 200;
			$this->message = '登陆成功';
			$this->setSession( $username );
		}
		$this->returnData();
	}

	public function logout()
	{
		\think\Session::clear();
		$this->returnData();
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
