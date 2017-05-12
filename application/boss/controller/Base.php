<?php
namespace app\boss\controller;

class Base extends \think\Controller
{
	public $code    = 200;
	public $message = 'success';
	public $data    = [];

	public function _initialize()
	{
		config('default_return_type','json');
		//暂时设置允许跨域
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: x-requested-with,content-type");
		header('Access-Control-Allow-Methods: OPTIONS,POST,GET');
		if( !session('username') )
		{
			$this->code    = 404;
			$this->message = 'have no login';
		}
		$this->returnData();
	}

	public function returnData()
	{
		return ['code'=>$this->code, 'message'=>$this->message, 'data' => $this->data];
	}
}
