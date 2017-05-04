<?php
namespace app\index\controller;
use Hprose\Http\Server;

class Index extends \think\Controller
{
	public function index()
	{
		$server = new Server("");
		$server->addFunction('genUuid');
		$server->start();
	}
}
