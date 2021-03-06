<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Request;
use Auth; //use thư viện auth

class messengerModel extends Model
{
    //
    protected $table = 'messenger';

    public function __construct()
    {
    }
    public function addItem(Request $request,$iduser)
    {
        if(count(messengerModel::where('idguest',$iduser)->where('iduser',Auth::user()->id)->get())==0)
        {
            $item = new messengerModel();
            $item->idguest = Auth::user()->id ;
            $item->iduser =$iduser;
            $item->status =1;
            $item->save();
        }
        $item = new messengerModel();
        $item->idguest = $iduser;
        $item->iduser = Auth::user()->id;
        $item->title = $request->title;
        $item->contents = $request->contents;
        $item->status =1;
        $item->save();
    }
    public function listAll()
    {
        $items = DB::table('messenger')
            ->join('users', 'users.id', '=', 'messenger.idguest')
            ->where('messenger.iduser',Auth::user()->id)
            ->groupBy('messenger.idguest','username','img')
            ->select('messenger.idguest','username','img')
            ->get();
        return $items;
    }
    public function checkStatus()
    {
        $items = DB::table('messenger')
            ->join('users', 'users.id', '=', 'messenger.idguest')
            ->where('messenger.iduser',Auth::user()->id)
            ->orwhere('messenger.idguest',Auth::user()->id)
            ->groupBy('messenger.idguest','username','img','messenger.status','messenger.iduser')
            ->select('messenger.idguest','username','img','messenger.status','messenger.iduser')
            ->get();
        return $items;
    }
    public function updateStatus($id)
    {
        $items=DB::update('UPDATE messenger SET status = 0 WHERE (iduser='.$id.' and idguest='.Auth::user()->id.') or ('.'iduser='.Auth::user()->id.' and idguest='.$id.')');
        return $items;
    }
//    public function listAll2()
//    {
//        $items = DB::table('messenger')
//            ->join('users', 'users.id', '=', 'messenger.idguest')
//            ->where('messenger.idguest',Auth::user()->id)
//            ->groupBy('messenger.iduser','username','img')
//            ->select('messenger.idguest','username','img')
//            ->get();
//        return $items;
//    }
    public function chatItem($id)
    {
        $items = DB::table('messenger')
//            ->where('messenger.iduser',Auth::user()->id)
//            ->where('messenger.idguest',$id)
            ->where([['messenger.iduser','=',Auth::user()->id],['messenger.idguest','=', $id]])
            ->orwhere([['messenger.iduser','=',$id],['messenger.idguest','=', Auth::user()->id]])
            ->get();
        return $items;
    }
}
