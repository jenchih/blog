<?php
namespace app\index\controller;
use Hprose\Swoole\Http\Server;
use app\index\model\User;
class Hprose
{
	public function index()
	{
		$model = new User();
		$server = new Server("http://192.168.130.129:1314");
		$server->addClassMethods($model);
		$server->debug       = true;
		$server->crossDomain = true;
		$server->start();
	}
}