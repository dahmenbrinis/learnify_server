<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinRoomRequest;
use App\Http\Requests\LeaveRoomRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        $myRooms =Auth::user()->rooms->pluck('id');
        return Room::query()
            ->whereNotIn('id',$myRooms)
            ->Where('visibility','=',1)
            ->orWhereIn('id',$myRooms)
            ->orderByDesc('id')
            ->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreRoomRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['image_name'])&&$validated['image_name']!=null){
//            TODO: implement the file upload.
        }else{
            $validated['image_name'] = ['biology.png','math.png','computer_science.png'][array_rand([0,1,2])];
        }
        return Auth::user()->rooms()->create($validated+['creator_id'=>Auth::id()]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Builder[]|Collection|Response
     */
    public function show(int $id)
    {
        return Room::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoomRequest $request
     * @param Room $room
     * @return Room
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        $room->refresh();
        return $room;
    }
    /**
     * join a room using a key if the room is private .
     *
     * @return Room
     */
    public function join(JoinRoomRequest $request,Room $room)
    {
        Auth::user()->rooms()->sync([$room->id]);
        $room->refresh() ;
        return $room;
    }

    /**
     * join a room using a key if the room is private .
     *
     * @return Room
     */
    public function leave(LeaveRoomRequest $request,Room $room)
    {
        Auth::user()->rooms()->detach([$room->id]);
        $room->refresh();
        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        return false ;
    }
}
