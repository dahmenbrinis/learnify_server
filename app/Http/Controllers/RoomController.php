<?php

namespace App\Http\Controllers;

use App\Gamify\Points\StudentCommendation;
use App\Http\Requests\JoinRoomRequest;
use App\Http\Requests\LeaveRoomRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Image;
use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use QCod\Gamify\Badge;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request)
    {
//        ray($request);
        $search = $request['search'];
        $myRooms =Auth::user()->rooms->pluck('id');
        $query = Room::query();
        if(isset($search))
            $query->where('rooms.name','like',"%$search%")
                ->orWhere('rooms.description','like',"%$search%");
        else
            $query->whereIn('id',$myRooms)
                ->orWhereNotIn('id',$myRooms)
                ->orderByDesc('id');
        return $query->paginate(12);
//        return Room::query()
//            ->whereNotIn('id',$myRooms)
//            ->Where('visibility','=',1)
//            ->orWhereIn('id',$myRooms)
//            ->orderByDesc('id')
//            ->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreRoomRequest $request)
    {
        $validated = $request->safe()->except('image');
        if (!isset($validated['image_name'])||$validated['image_name']==null){
            $validated['image_name'] = ['biology.png','math.png','computer_science.png'][array_rand([0,1,2])];
        }
        $room = Auth::user()->rooms()->create($validated+['creator_id'=>Auth::id()]);
        if (isset($request->validated()['image'])&&$request->validated()['image']!=null){
            $path = $request->file('image')->store('/', 'images');
            $image =  Image::query()->create([
                'src' => $path,
                'user_id' => auth()->id() ,
                'imagable_type'=>Room::class,
                'imagable_id'=>$room->id,
            ]);
            ray($image);
        }
        if($request['visibility'] == Room::$PublicRoom){
            $room->update(['code'=>null]);
        }

        Auth::user()->rooms()->syncWithoutDetaching([$room->id]);
        $room->refresh() ;
        return $room;
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
        $room->update($request->safe()->except('image'));
        if (isset($request->validated()['image'])&&$request->validated()['image']!=null){
            $path = $request->file('image')->store('/', 'images');
            $image =  Image::query()->updateOrCreate(
                ['imagable_type'=>Room::class, 'imagable_id'=>$room->id],
                ['src' => $path,'user_id' => auth()->id()]
            );
            ray($image);
        }

        if($request['visibility'] == Room::$PublicRoom){
            $room->update(['code'=>null]);
        }
        $room->refresh();
        return $room;
    }



    /**
     * get leaderboard list of a room .
     *
     * @return LengthAwarePaginator
     */
    public function leaderboard(Room $room)
    {
        return $room->leaderBoard()->orderByDesc('points')->paginate(300);
    }

    /**
     * get list of students who .
     *
     * @return LengthAwarePaginator
     */
    public function management(Room $room)
    {
        if(!Auth::user()->can('update',$room)) return null ;
        return $room->users()->orderByDesc('users.type')
//            ->where('users.type','=',User::$Student)
            ->where('users.id','<>',Auth::id())
            ->withCount('questions')
            ->withCount('comments')
            ->withCount('votes')->paginate(300);
    }

    /**
     * join a room using a key if the room is private .
     *
     * @return Room
     */
    public function join(JoinRoomRequest $request,Room $room)
    {
        Auth::user()->rooms()->syncWithoutDetaching([$room->id]);
        $room->refresh();
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
     * kick a student from the room .
     *
     * @return bool
     */
    public function kick(Room $room , User $user)
    {
        ray('teacher can kick :',Auth::user()->can('update',$room));
        if(!Auth::user()->can('update',$room)) return false ;
        $user->rooms()->detach([$room->id]);
        $room->refresh();
        return true ;
    }

    /**
     * commend a student from the room .
     *
     * @return bool
     */
    public function commend(Room $room , User $user)
    {
        ray(Badge::query()->where('name','Recommended')->first());
        if(!Auth::user()->can('update',$room)) return false ;
        if($user->studentCommendation()->where('teacher_id',Auth::id())->exists()) return true;
        $user->studentCommendation()->syncWithoutDetaching(Auth::user());
        givePoint(new StudentCommendation($room, $user));
//        ray($badge);
//        $user->rooms()->detach([$room->id]);
//        $room->refresh();
        return true ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Room  $room
     * @return bool
     */
    public function destroy(Room $room)
    {
        $bool = $room->delete();
        ray($room,$bool);
        return  $bool;
    }
}
