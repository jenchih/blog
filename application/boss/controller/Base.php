<?php
namespace app\boss\controller;

class Base extends \think\Controller
{
	public function _initialize()
	{
		config('default_return_type','json');
		//暂时设置允许跨域
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: x-requested-with,content-type");
		header('Access-Control-Allow-Methods: OPTIONS,POST,GET');
		if( !session('username') )
		{
			return ['code'=>404, 'message'=>'have no login'];
		}
		return ['code'=>200, 'message'=>'ok'];
	}

	public function test()
	{
	}

	public function index()
	{
	}
}
