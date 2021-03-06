<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\messengerModel;
use App\Model\usersModel;
use Illuminate\Http\Request;
use Session;

class messagingController extends Controller
{
    //
    private $mess, $user;
    public function __construct()
    {
        $this->user= new usersModel();
        $this->mess=new messengerModel();
    }
    public function listAll()
    {
        $data['items']=$this->mess->listAll();
        $data['items2']=$this->mess->checkStatus();
        return view('admin.messenger',$data);
    }
    public function addItem(Request $request)
    {
        if(isset($request->email))
        {
            $user=$this->user->getIdEmail($request->email);
            $iduser=isset($user[0])?$user[0]->id:null;
            if ($iduser == null) {
                Session::flash('error', 'Không tìm thấy Email !');
            } else {
                $this->mess->addItem($request, $iduser);
            }
            return back();
        }
        else{
            return back();
        }
    }
    public function chatItem($id)
    {
        $this->mess->updateStatus($id);
        $data['infoguest']=$this->user->showItem($id);
        $data['items']=$this->mess->listAll();
        $data['itemDetail']=$this->mess->chatItem($id);
        $data['items2']=$this->mess->checkStatus();
        return view('admin.messenger',$data);
    }
    public function addChat(Request $request, $id)
    {
        $this->mess->addItem($request,$id);
        $data['infoguest']=$this->user->showItem($id);
        $data['items']=$this->mess->listAll();
        $data['itemDetail']=$this->mess->chatItem($id);
        $data['items2']=$this->mess->checkStatus();
        return view('admin.messenger',$data);
    }
}
