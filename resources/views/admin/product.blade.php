@extends('admin.Base')
@section('title','Danh mục sản phẩm')
@section('main')
    <style>
        .btn{
            padding: 0;
        }
    </style>
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{asset('admin')}}">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">sản phẩm</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sản phẩm</h1>
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="btn btn-primary" href="{{asset('admin/product/add')}}">Thêm sản phẩm</a>
                </div>
                <div class="panel-body">
                        <table id="tb1" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá bán</th>
                                <th>Tình trạng sản phẩm</th>
                                <th># Tag</th>
                                <th>Mô tả ngắn</th>
                                <th>Trạng thái</th>
                                <th>Thời gian hiện thị</th>
                                <th>Chế độ</th>
                                <th>Tùy chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr class="onRow">
                                    <td scope="row">{{$item->id}}</td>
                                    <td>{{$item->title}}</td>
                                    <td><img class="thumbnail" width="100px" src="{{isset($item->coverimg)?asset('public/media/'.$item->coverimg):asset('public/images/shirt-render.jpg')}}" ></td>
                                    <td>{{number_format($item->price,0,',','.')}} VNĐ</td>
                                    <td>{{$item->statustype==0?'Hết hàng':'Còn hàng'}}</td>
                                    <td>{{$item->tag}}</td>
                                    <td>{{$item->describe}}</td>
                                    <td>{{$item->status==1?'Mới':'Cũ'}}</td>
                                    <th>{{14-(int)((time()-strtotime($item->created_at))/86400) }} ngày</th>
                                    <td><a class="btn" href="{{asset('admin/product/toggle/'.$item->id.'-'.($item->toggle==1?'0':'1'))}}"><i class="{{$item->toggle==1?'fa fa-eye':'fa fa-eye-slash'}}" aria-hidden="true"></i></a></td>
                                    <td>
                                        <a class="btn btn-info" href="{{asset('admin/product/update/'.$item->id)}}">Sửa</a>
                                        <a class="btn btn-danger" href="{{asset('admin/product/delete/'.$item->id)}}">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div><!-- /.panel-->
    </div><!-- /.col-->
    <div class="col-sm-12">
        <p class="back-link">DOIDO.COM</p>
    </div>
    </div><!-- /.row -->
@stop
