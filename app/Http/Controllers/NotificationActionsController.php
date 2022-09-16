<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationActionsController extends Controller
{
    public function clear($noticeId = null){
        if($noticeId == null){
            //get all noticications
            $all_notices = Auth::user()->unreadNotifications()->get();
            //dd($all_notices);
            foreach($all_notices as $notice){
                $notice->markAsRead();
            }
            return true;
        }else{
            $notice = Auth::user()->notifications()->where('id',$noticeId)->first()->markAsRead();
            return json_encode(Auth::user()->unreadNotifications()->get());
        }
    }
}
