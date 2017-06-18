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
		header('Access-Control-Allow-Methods:POST,GET');

		// if( !session('username') )
		// {
		// 	$this->code    = 110;
		// 	$this->message = 'have no login';
		// 	header('Content-Type: application/json');
		// 	header('Content-Type: text/html;charset=utf-8');
		// 	echo json_encode($this->returnData());die;
		// }
	}

	public function returnData()
	{
		#echo json_encode(['code'=>$this->code, 'message'=>$this->message, 'data' => $this->data]);die;
		return ['code'=>$this->code, 'message'=>$this->message, 'data' => $this->data];
	}
}
