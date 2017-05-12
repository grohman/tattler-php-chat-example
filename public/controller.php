<?php

use Tattler\Base\Channels\IUser;
use Tattler\Base\Modules\ITattler;
use Tattler\Base\Objects\ITattlerMessage;
use Tattler\Common;
use Tattler\Objects\TattlerConfig;


require_once "../vendor/autoload.php";


session_start();

$get = $_GET;
$post = $_POST;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();


/** @var ITattler $tattler */
$tattler = Common::skeleton(ITattler::class);

$config = new TattlerConfig();
$config->WsAddress = getenv('TATTLER_WS');
$config->ApiAddress = getenv('TATTLER_API');
$config->Secret = getenv('TATTLER_SECRET');
$config->Namespace = getenv('TATTLER_NAMESPACE');

$tattler->setConfig($config);

if (isset($get['ws']))
{
	echo json_encode(['ws' => $tattler->getWsAddress()]);
}
else if (isset($get['channels']))
{
	/** @var IUser $user */
	$user = Common::skeleton(IUser::class);
	$user->setName(session_id())->setSocketId($get['socketId']);
	
	$tattler->setUser($user);
	
	echo json_encode(['channels' => $tattler->getChannels()]);
}
else if (isset($get['auth']))
{
	echo json_encode(['token' => $tattler->getJWTToken()]);
}
else if ($post)
{
	/** @var ITattlerMessage $tattlerMessage */
	$tattlerMessage = Common::skeleton(ITattlerMessage::class);
	$tattlerMessage->setHandler('message')->setPayload(['message' => $post['message']]);
	$tattler->message($tattlerMessage)->broadcast()->say();
	
	echo json_encode(['ok']);
}