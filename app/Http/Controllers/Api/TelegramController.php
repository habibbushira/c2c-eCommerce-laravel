<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\RequestTrait;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    //
    use RequestTrait;

    public function webhook(){
    	return $this->apiRequest('setWebhook', [
    		'url'=>str_replace("http", 'https', url(route('webhook')))
    		]) ? ['success'] : ['something wrong'];
    }

    public function index(){
    	$update = json_decode(file_get_contents("php://input"));
    	if(isset($update->message)){
    		$message = $update->message;
    		if(isset($message->text)){
    			switch ($message->text) {
    				case '/start':
    					$this->apiRequest('sendMessage', [
    						'chat_id' => $message->chat->id,
    						'text' => 't.me/cushcommerce',
    					]
    					);
    					break;
    				
    				default:
    					$this->apiRequest('sendMessage', [
    						'chat_id' => $message->chat->id,
    						'text' => 't.me/cushcommerce'
    					]
    					);
    					break;
    			}
    		}
    	}
    }

    public function updatedActivity(){
    	$activity = Telegram::getUpdates();
        dd($activity);
    }
}