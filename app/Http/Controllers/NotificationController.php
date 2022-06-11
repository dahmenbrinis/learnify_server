<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        ray(Auth::user(),Auth::user()->notifications);
        if(Auth::user()== null) return null ;
        return Auth::user()->notifications()->paginate(50);
    }
    public function count()
    {
        if(Auth::user()== null) return null ;
        return Auth::user()->notifications()->count();
    }
    public function markRead()
    {
        if(Auth::user()== null) return 0;
        Auth::user()->notifications->markAsRead();
        return 1;
    }
}
