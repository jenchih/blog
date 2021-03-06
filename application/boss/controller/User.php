<?php
namespace app\boss\controller;
use think\Db;

class User extends \think\Controller
{
	public function _initialize()
	{
		config('default_return_type','json');
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: x-requested-with,content-type");
		header('Access-Control-Allow-Methods: POST,GET');
	}

	public function loginvalid()
	{
		$return            = [];
		$return['code']    = 400;
		$return['message'] = '账号或密码错误';
		$username          = input('username','');
		$pwd               = input('password','');

		$res = Db::table('admin')->where('username', $username)->find();
		if( empty($res) )
		{
			return $return;
		}

		$passHashModel = new \app\boss\model\User;
		if( $passHashModel->check_password($res['password'],config('pwd_cfg').$pwd) )
		{
			$return['code']    = 200;
			$return['message'] = '登陆成功';
			$this->setSession( $username );
		}
		return $return;
	}

	public function logout()
	{
		\think\Session::clear();
		$return['code']    = 200;
		$return['message'] = '登陆成功';
		return $return;
	}

	private function setSession($username)
	{
		//do something else
		session('username', $username);
	}

	private function check_password($hash, $password) 
	{ 
		$full_salt = substr($hash, 0, 29); 
		$new_hash = crypt($password, $full_salt); 
		return ($hash === $new_hash); 
	} 
}
