<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\Lga;
use App\Store;
use App\Ward;
use App\Bed;
use App\User;
use DB;
use Illuminate\Support\Facades\Input;

class GeneralOptionController extends Controller
{
    public function mystateAjax($id){
        $lgas = LGA::where("state_id", "=", $id)->pluck("name", "id");
        return json_encode($lgas);
    }

    public function mywardAjax($id){
        $beds = Bed::where("ward_id", "=", $id)->whereStatus(0)->whereVisible(1)->pluck("bed_name", "id");
        return json_encode($beds);
    }

    public function mystoreAjax($id){
        $stores = Store::where("lga_id", "=", $id)->pluck("store_name", "id");
        return json_encode($stores);
    }

    public function getUsersBasedOnStatusCategory($id){
        // $users = User::where("is_admin", "=", $id)->pluck("name", "id");
        $users = User::where('is_admin', '=', $id)->whereIn('is_admin', [20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30])->orderBy('id', 'asc')->get(['surname','firstname','othername','id'])->pluck('name', 'id');
        return json_encode($users);
    }
}
