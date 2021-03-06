<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth; //use thư viện auths
use DB;

class orderModel extends Model
{
    //
    protected $table = 'orderproduct';
    public $product;
    public function __construct()
    {
        $this->product=new productModel();
    }
    public function listAll()
    {
       // $item = orderModel::orderBy('created_at', 'DESC')->get();
        $items=DB::select('SELECT t.id, t.status, t.idproductex,t.idproductre,ls.id userid1,le.id userid2, ls.username username1, le.username username2 FROM orderproduct t JOIN users ls
ON      ls.id = t.iduser
JOIN    users le
ON      le.id = t.idguest');
        return $items;
    }
    public function addItem($request)
    {
        try {
            $item = new orderModel();
            $item->iduser = $request['iduser'];
            $item->idguest = $request['idguest'];
            $item->idproductex = $request['idproductex'];
            $item->idproductre = $request['idproductre'];
            $item->style = $request['style'];
            $item->save();
            return $item->id;
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }
    public function listOrder()
    {
        $items = DB::table('orderproduct')
            ->join('users', 'users.id', '=', 'orderproduct.idguest')
            ->join('product', 'orderproduct.idproductre', '=', 'product.id')
            ->where('orderproduct.iduser', Auth::user()->id)
            ->select('*', 'orderproduct.style as orderType', 'orderproduct.id as idOrder', 'orderproduct.status as orderStatus')
            ->get();
        return $items;
    }

    public function listOrderGuest()
    {
        $items = DB::table('orderproduct')
            ->join('users', 'users.id', '=', 'orderproduct.iduser')
            ->join('product', 'orderproduct.idproductex', '=', 'product.id')
            ->where('orderproduct.idguest', Auth::user()->id)
            ->select('*', 'orderproduct.style as orderType', 'orderproduct.id as idOrder', 'orderproduct.status as orderStatus')
            ->get();
        return $items;
    }

    public function showItem($id)
    {
        $item = orderModel::find($id);
        return $item;
    }

    public function updateStatus($id, $status)
    {
        $idproduct=orderModel::find($id);
       // $idproductex=
        if($status==0)
        {
            $this->product->updateStatus($idproduct['idproductex'],1);
            $this->product->updateStatus($idproduct['idproductre'],1);
            DB::table('orderproduct')->where('idproductex',$idproduct['idproductex'])
                ->where('id','!=',$idproduct['id'])
                ->update(['status' => 0]);
        }
        else{
            $this->product->updateStatus($idproduct['idproductex'],0);
            $this->product->updateStatus($idproduct['idproductre'],0);
            DB::table('orderproduct')->where('idproductex',$idproduct['idproductex'])
                ->where('id','!=',$idproduct['id'])
                ->update(['status' => 3]);
        }
        $idproduct->status = $status;
        $idproduct->save();
        return true;
    }

    public function updateItem(Request $request, $id)
    {
        try {
            $item = new orderModel();
            $item->iduser = $request->iduser;
            $item->total = $request->total;
            $item->status = $request->status;
            $item->save();
            return true;
        } catch (Exception $ex) {
            report($ex);
            return false;
        }

    }

    public function deleteItem($id)
    {
        try {
            orderModel::destroy($id);
            return true;
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }
    public function productEx($id)
    {
        $item = DB::table('orderproduct')
            ->join('product', 'orderproduct.idproductex', '=', 'product.id')
            ->where('orderproduct.id', $id)
            ->get();
        return $item;
    }

    public function productRe($id)
    {
        $item = DB::table('orderproduct')
            ->join('product', 'orderproduct.idproductre', '=', 'product.id')
            ->where('orderproduct.id', $id)
            ->get();
        return $item;
    }

    public function orderUser($id)
    {
        $item = DB::table('orderproduct')
            ->join('users', 'orderproduct.idguest', '=', 'users.id')
            ->where('orderproduct.id', $id)
            //->select('*','orderproduct.style as orderType','orderproduct.id as idOrder')
            ->get();
        return $item;
    }
    public function orderUser2($id)
    {
        $item = DB::table('orderproduct')
            ->join('users', 'orderproduct.iduser', '=', 'users.id')
            ->where('orderproduct.id', $id)
            //->select('*','orderproduct.style as orderType','orderproduct.id as idOrder')
            ->get();
        return $item;
    }

    public function countMonth()
    {
        $item = DB::select('SELECT 
    (MONTH(created_at)) AS month, COUNT(*) AS so
FROM
    `orderproduct`
GROUP BY month(created_at)
ORDER BY month DESC
LIMIT 2');
        return $item;
    }
}
