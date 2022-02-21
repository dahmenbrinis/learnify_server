<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
//        Room::all()->filter(function (Room $room) {
//            return Auth::user()->can('view',$room);
//        });
        $x = Auth::user()
            ->rooms()
            ->orWhere('visibility','=',1)->count();
        $myRooms =Auth::user()->rooms->pluck('id');
//$y = Room::query()->whereNotIn('id',$myRooms)->where('visibility','=',1)->orWhereIn('id',$myRooms)->count();
        return Room::query()
            ->whereNotIn('id',$myRooms)
            ->Where('visibility','=',1)
            ->orWhereIn('id',$myRooms)
            ->orderByDesc('id')
            ->paginate(12)
            ->items();

//        return Auth::user()
//            ->rooms()
//            ->orWhere('visibility','=',1)
//            ->rooms()->distinct()
////            ->whereNotIn('id',Auth::user()->rooms)
//            ->orderByDesc('id')
//            ->paginate(12)
//            ->items();
//        return Room::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>"required|min:3",
            'description'=>"required|min:10",
            'image_name'=>"sometimes|nullable|image",
            'visibility'=>['required',Rule::in(array_keys(Room::$Visibilities))],
            'level_id'=>['required',Rule::exists('levels','id')],
        ])+['creator_id'=>Auth::id()];
        if (isset($validator['image_name'])&&$validator['image_name']!=null){
//            TODO: implement the file upload.
        }else{
            $validator['image_name']= ['biology.png','math.png','computer_science.png'][array_rand([0,1,2])];
        }
        if ( Auth::user()->cannot('create',Room::class)) return response(['message'=>'forbidden action'],301);
        return Auth::user()->rooms()->create($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Response
     */
    public function show($id)
    {
        return Room::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Room  $id
     * @return Room|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function update(Request $request, Room $room)
    {
//        dd(Auth::id(),$room);

        $validator = $request->validate([
            'id'=>'required',
            'name'=>"sometimes|min:3",
            'description'=>"sometimes|min:10",
            'visibility'=>['sometimes',Rule::in(array_keys(Room::$Visibilities))],
            'level_id'=>['sometimes',Rule::exists('levels','id')],
        ]);
        if (Auth::user()->cannot('update',$room)) return response(['message'=>'access forbidden '],301);
        $room->update($validator);
        $room->refresh() ;
        return $room ;
    }
    /**
     * join a room using a key if the room is private .
     *
     * @return Room|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function join(Request $request,Room $room)
    {
        if(Auth::user()->cannot('join',$room))
            return response(['message'=>'you are already subscribed to this room'],301);
        if($room->visibility === Room::$PrivateRoom and $room->id!==$request['code'])
            return response(['message'=>'access forbidden '],301);
//      otherwise, join the room .
        Auth::user()->rooms()->syncWithoutDetaching([$room->id]);
//        $room->name = 'testting';
        $room->refresh();
//        $count = $room->userCount;
        return $room;
    }
    /**
     * Display a listing of the resource using a search query.
     *
     * @return Response
     */
    public function search(string $search)
    {

//        $x =Auth::user()->rooms()->orderByDesc('id')->paginate(12);
        return Auth::user()->rooms()->orderByDesc('id')->paginate(12)->items();
//        return Room::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
