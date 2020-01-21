<?php

namespace App\Http\Controllers;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function saveMessage(Request $request)
    {
        $message = new Message();
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => $request->message,
        ], 200);
    }

    public function getOldMessages(Request $request)
    {
        $messages = array();

        $oldMessages = Message::where([
                ['sender_id', $request->shop_id],
                ['receiver_id', $request->vendor_id],
            ])
            ->orWhere([
                ['receiver_id', $request->shop_id],
                ['sender_id', $request->vendor_id],    
            ])
            ->get();

        foreach ($oldMessages as $key => $oldMessage) {
            $sender = User::findOrFail($oldMessage['sender_id']);
            $receiver = User::findOrFail($oldMessage['receiver_id']);
            $message = [
                'id' => $oldMessage['id'],
                'sender_id' => $sender->id,
                'sender_name' => $sender->name,
                'receiver_id' => $receiver->id,
                'receiver_name' => $receiver->name,
                'message' => $oldMessage['message'],
                'date' => $oldMessage['created_at']->format('j F'),
                'time' => $oldMessage['created_at']->timezone('Asia/Novosibirsk')->format('H:i'),
            ];
            array_push($messages, $message);
        }

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ], 200);
    }

    public function sendMessage(Request $request)
    {
        

        $message = new Message();
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        $sender = User::findOrFail($request->sender_id);
        $receiver = User::findOrFail($request->receiver_id);

        $newMessage = [
            'channel' => $request->channel,
            'id' => $message->id,
            'sender_id' => $sender->id,
            'sender_name' => $sender->name,
            'receiver_id' => $receiver->id,
            'receiver_name' => $receiver->name,
            'message' => $message->message,
            'date' => $message->created_at->format('j F'),
            'time' => $message->created_at->timezone('Asia/Novosibirsk')->format('H:i'),
        ];

        event(new NewMessage($newMessage));

        return response()->json([
            'status' => 'success',
            'message' => $newMessage,
        ], 200);
    }
}
