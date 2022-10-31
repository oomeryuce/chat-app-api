<?php

namespace App\Http\Controllers;

use App\Models\MessageParticipants;
use App\Models\Messages;
use App\Models\Rooms;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $roomParticipants = MessageParticipants::where('user_id', auth()->id())->pluck('room_id')->toArray();
        $returnData = Rooms::whereIn('id', $roomParticipants)
            ->with("participants")
            ->orderBy('created_at','desc')
            ->paginate(10);

        $returnData->map(function($room, $key) {
            $lastMessage = Messages::where('room_id', $room->id)->orderBy('created_at','desc')->first();
            $room->last_message = $lastMessage;
        });

        return (new ApiController())->ApiCreator($returnData);
    }

    /**
     * Get messages by room id.
     *
     * @return JsonResponse
     */
    public function getMessages(int $id)
    {
        // $roomSecurity = Rooms::where('id', $id)->where('from', auth()->id())->orWhere('to',  auth()->id())->get();
        $roomSecurity = MessageParticipants::where('room_id', $id)->where('user_id', auth()->id())->get();
        if (count($roomSecurity) === 0) {
            return (new ApiController())->ApiCreator('Busted!', true);
        }
        $messages = Messages::where('room_id', $id)->with('user')->orderBy('created_at','desc')->paginate(10);
        return (new ApiController())->ApiCreator($messages);
    }

    /**
     * Delete a message by message id.
     *
     * @return JsonResponse
     */
    public function deleteMessage(int $id)
    {
        try {
            Messages::find($id)->delete();
            return (new ApiController())->ApiCreator('Message deleted succesfully!');
        } catch (Throwable $e) {
            return (new ApiController())->ApiCreator($e, true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $to = $request->to;
        $isGroup = $request->isGroup;
        if ($isGroup && is_array($to)) {
            $user = User::whereIn('id', $to)->count();
            if ($user === 0) {
                return (new ApiController())->ApiCreator('Users not found!', true);
            }
            $room = new Rooms();
            $room->name = $request->name;
            $room->is_group = $isGroup;
            $room->save();

            $participants = new MessageParticipants();
            $participants->room_id = $room->id;
            $participants->user_id = auth()->id();
            $participants->is_admin = true;
            $participants->save();

            for ($i = 0; $i < count($to); $i++){
                $participants = new MessageParticipants();
                $participants->room_id = $room->id;
                $participants->user_id = $to[$i]['id'];
                $participants->is_admin = false;
                $participants->save();
            }
            $data = Rooms::where('id', $room->id)->with('participants')->first();
            return (new ApiController())->ApiCreator($data);
        } elseif(!$isGroup && is_integer($to)) {
            $user = User::where('id',$to)->count();
            if ($user === 0) {
                return (new ApiController())->ApiCreator('User not found!', true);
            }
            $newMessageControll = Rooms::where('users_id', auth()->id() . '_' . $to)->orWhere('users_id', $to . '_' . auth()->id())->first();
            if (is_null($newMessageControll)) {
                $room = new Rooms();
                $room->is_group = false;
                $room->users_id = auth()->id() . '_' . $to;
                $room->save();

                $participants = new MessageParticipants();
                $participants->room_id = $room->id;
                $participants->user_id = auth()->id();
                $participants->is_admin = false;
                $participants->save();

                $participants = new MessageParticipants();
                $participants->room_id = $room->id;
                $participants->user_id = $to;
                $participants->is_admin = false;
                $participants->save();

                $data = Rooms::where('id', $room->id)->with('participants')->first();
                return (new ApiController())->ApiCreator($data);
            } else {
                return (new ApiController())->ApiCreator($newMessageControll);
            }
        }
        return (new ApiController())->ApiCreator('Something went wrong!', true);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:1|max:400',
            'roomId' => 'required',
        ]);if ($validator->fails()) {
        return (new ApiController())->ApiCreator($validator->errors()->all(), true);
        }
        $text = $request->text;
        // $image = $request->image;
        $roomId = $request->roomId;

        $message = new Messages();
        $message->user_id = $request->user()->id;
        $message->room_id = $roomId;
        $message->text = $text;
        $message->save();

        return (new ApiController())->ApiCreator($message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
