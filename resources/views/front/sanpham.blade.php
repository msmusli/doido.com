@extends('front.Base')
@section('title','DOIDO.COM | Thế giới đổi đồ')
@section('main')
    <style>
        .footer-box-center .hidden-xs {
            margin-top: 30px;
        }

    </style>
    <div class="box-content">
        <script type='text/javascript' src="js/jquery.slimscroll.min.js"></script>
        <script type='text/javascript' src="js/bootstrap-slider.js"></script>
        <div class="heading-area top-area">
            <div class="container">
                <div class="banner relative">
                    <a href="hang-moi.html" target="_blank">
                        <img class="lazyload" data-src="images/bannerfooter.jpg" style="width: 100%">
                        <div class="banner_body center">
                            <div class="upcase banner_header"></div>
                            <div class="banner_description text-justify"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div> <!-- End heading area -->
        <div class="content-area home-content-area">
            <div class="container">
                <div class="navigation">
                    <a href="index.blade.php">Trang chủ</a> > <a href="{{asset('product ')}}">Danh mục sản phẩm</a>
                </div>
                <div class="paging-top row">
                    <div class="col-md-12">
                        <div class="cat-name">
                            <div class="text-center ld-product-type">
                                <span class="upcase active">Danh mục sản phẩm</span>
                            </div>
                        </div>
                        <div class="cat-title-gray"></div>
                    </div>
                </div>
                <div class="row prod-list">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-3" style="border-right: 1px solid #cccccc">
                                <div class="">
                                    <div class="product-type1">
                                        <div class="row">
                                            <div class="col-xs-9 heading"
                                                 style="font-weight: bolder;font-size: 14px;text-transform: uppercase;">
                                                Danh mục
                                            </div>
                                        </div>
                                        <ul>
                                            <li>
                                                <a class="" href="{{asset('search/Đồ điện tử')}}">Đồ điện tử</a>
                                            </li>
                                            <li><a class="" href="{{asset('search/Đồ văn phòng')}}">Đồ văn phòng</a>
                                            </li>
                                            <li><a class="" href="{{asset('search/Đồ dùng cá nhân')}}">Đồ dùng cá
                                                    nhân</a>
                                            </li>
                                            <li><a class="" href="{{asset('search/Đồ giải trí')}}">Giải trí, thể
                                                    thao</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-price" id="product-price-tab">
                                        <form method="get" action="{{asset('searchprice')}}">
                                            <div class="row">
                                                <div class="col-xs-9 heading">Giá</div>
                                            </div>
                                            <div id="lblPrice"></div>
                                            <p>Min</p>
                                            <input class="form-control" type="number" name="min" value="1000">
                                            <p>Max</p>
                                            <input class="form-control" type="number" name="max" value="100000">
                                            <br>
                                            <button class="btn">Lọc</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row product-filter" style="display:hidden;">
                                    <div class="col-md-12 secondary-filters">
                                        <div class="leftnav-active-filter" id="filter-lists">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="list-product-ajax">

                                    <?php $check = 0 ?>
                                    @foreach($items as $item)
                                        <?php $check = 1?>
                                        @if($item->statustype==1)
                                            <div class="col-sm-4  col-xs-6">
                                                <div class="prod-img1">
                                                    <a href="{{asset('/product-'.$item->id)}}" class="">
                                                        <img data-src="{{asset('public/media/'.$item->coverimg)}}"
                                                             class="lazyload"/>
                                                    </a>
                                                </div>
                                                <div class="content ">
                                                    <a href="{{asset('/product-'.$item->id)}}">
                                                        <div class="title"><span>{{$item->title}}</span></div>
                                                        <div class="desc"><span>{{$item->describe}}s<br>
                                                    <span class="color-red">
                                                        {{number_format($item->price,0,',','.')}} VND
                                                        </span>
                                                                                                        </span>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($check==0)
                                        <center><span
                                                    style="font-size: 18px; color: #cccccc">Không tìm thấy sản phẩm.</span>
                                        </center>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right paging-bottom" id="pagging-ajax">
                            {{$items->links()}}
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="txtStyle" value=""/>
        </div><!-- End content area -->
    </div>
@stop
<style>
    .product-type1 li {
        padding: 5px 0;
    }

    .product-type1 ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
</style>