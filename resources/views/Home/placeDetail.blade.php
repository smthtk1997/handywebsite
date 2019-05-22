@extends('layouts.header')
@section('title','รายละเอียดสถานที่')
@section('style')
    <link href="{{asset('libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
    <style>

    </style>
@stop
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">รายละเอียดร้าน</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('back.page')}}">การค้นหา</a>
                            </li>
                            <li class="breadcrumb-item active">รายละเอียดสถานที่</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="shadow bg-white rounded">
                    <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 50px">
                        <div class="mb-3">
                            <h2>{{$shop->name}}</h2>
                            <h5 class="{{$openNow == true ? 'text-success':'text-danger'}}">{{$openNow == true ? 'เปิดอยู่ขณะนี้':'ปิดอยู่ขณะนี้'}}</h5>
                        </div>
                        @if ($photo_toshow)
                            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($photo_toshow as $photo_shop)
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="{{$loop->iteration-1}}" class="{{$loop->iteration-1 == 0 ? 'active':''}}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    @foreach($photo_toshow as $photo_shop)
                                        <div class="carousel-item {{$loop->iteration == 1 ? 'active':''}}">
                                            <img class="img-fluid" style="width: 100%;height: 400px;max-height: 400px;object-fit: cover" src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference={{$photo_shop}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk" alt="{{$loop->iteration.'slide'}}">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </a>
                            </div>
                        @endif
                        <hr style="margin-top: 30px;margin-bottom: 30px">


                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li role="presentation" class="nav-item">
                                <a href="#information" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="mdi mdi-information"></i> รายละเอียด</span>
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a href="#gallery" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="ti ti-gallery"></i> อัลบั้ม</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="information">
                                <h4><i class="fas fa-map-marker-alt"></i> ที่อยู่ร้าน</h4>
                                <p style="font-size: 15px">{{$shop->formatted_address}}</p>
                                @if ($shop->phone_number)
                                    <h5 style="margin-bottom: 13px"><i class="fas fa-mobile-alt"></i> เบอร์โทรติดต่อ: <span><a style="font-size: 15px;" href="tel:{{$shop->phone_number}}" style="font-size: 15px">{{str_replace('+66-','0',$shop->phone_number)}}</a></span></h5>
                                @endif
                                <p style="font-size: 15px">
                                    <i class="far fa-smile"></i> คะแนนจากเว็บ:
                                    @if (!$shop->rating)
                                        @for ($i = 0; $i < 5; $i++)
                                            <img src="{{asset('images/star/star-off.png')}}" alt="{{$shop->rating}}" width="18px" height="18px" style="object-fit: cover;margin-top: -4px">
                                        @endfor
                                    @else
                                        @for ($i = 0; $i < (int)$shop->rating; $i++)
                                            <img src="{{asset('images/star/star-on.png')}}" alt="{{$shop->rating}}" width="18px" height="18px" style="object-fit: cover;margin-top: -4px">
                                        @endfor
                                    @endif
                                </p>
                                @if ($weekdays)
                                    <hr style="margin-top: 0px">
                                    <h5 style="margin-bottom: 18px;margin-top: 5px" class="{{$openNow == true ? 'text-success':'text-danger'}}"><i class="far fa-clock"></i> เวลาเปิดทำการ</h5>
                                    @foreach ($weekdays as $work)
                                        @php
                                        $string = explode(":",$work);
                                        @endphp

                                        @if ($string[0] == \Carbon\Carbon::now()->englishDayOfWeek)

                                            <p style="font-size: 15px" class="{{ $openNow ? "text-success" : "text-danger"}}">{{$work}}</p>

                                            @else
                                            <p style="font-size: 15px">{{$work}}</p>
                                        @endif

                                    @endforeach
                                @endif
                            </div>
                            <div role="tabpanel" class="tab-pane" id="gallery">
                                @if ($photo_toshow)
                                    <div class="row">
                                        @foreach($photo_toshow as $photo_shop)
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <img class="centerOfRow image-popup-vertical-fit imageGrow mb-3" style="width: 100%;height: 200px;max-height: 200px;object-fit: cover;border-radius: 2%" src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={{$photo_shop}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk" alt="{{$loop->iteration.'slide'}}" href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference={{$photo_shop}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk">
                                            </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-danger">ไม่มีรูปให้แสดง</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="shadow bg-white rounded">
                    <div class="card cardColor cardStyleMargin" style="padding: 20px">
                        <h4 style="margin-bottom: 0.8rem"><i class="fas fa-map-marked-alt"></i> แสดงบนแผนที่</h4>
                        <div id="map"></div>
                        <a href="{{$shop->url_nav}}"
                           class="btn btn-googleplus waves-effect waves-light mt-2"
                           target="_blank">นำทางโดย Google Map</a>
                    </div>
                </div>
                <div class="shadow bg-white rounded">
                    <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 50px">
                        <h4 style="margin-bottom: 1.3rem">รีวิวจากลูกค้า</h4>
                        @if ($reviews_toshow)
                            @foreach ($reviews_toshow as $review)
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2"><img src="{{$review['profile_photo']}}" alt="user" width="50" class="rounded-circle"></div>
                                    <div class="comment-text">
                                        <h6 class="font-medium">{{$review['user_name']}}</h6>
                                        <span class="m-b-15 d-block">{{$review['text']}}</span>
                                        <div class="comment-footer" style="margin-top: 0.3rem">
                                            <span class="text-muted float-right">ให้คะแนน: {{$review['give_rate']}}/5</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif
                        @if ($reviews_handy)
                            @foreach ($reviews_handy as $handy)
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2">
                                        @if ($handy->get_user->avatar)
                                            <img src="{{url('user_img/'.$handy->get_user->avatar)}}" alt="user" width="50" class="rounded-circle">
                                            @else
                                            <img src="{{url('user_img/'.'user.jpg')}}" alt="user" width="50" class="rounded-circle">
                                        @endif
                                    </div>
                                    <div class="comment-text">
                                        <h6 class="font-medium">{{$handy->get_user->name}}</h6>
                                        <span class="m-b-15 d-block">{{$handy->message}}</span>
                                        <div class="comment-footer" style="margin-top: 0.3rem">
                                            <span class="text-muted float-right">ให้คะแนน: {{$handy->rating}}/5</span>
                                            <small class="text-muted">รีวิวจากผู้ใช้ Handy</small>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif
                        @if (!$reviews_handy && $reviews_toshow)
                            <p class="text-info">ยังไม่มีรีวิวจากลูกค้า</p>
                        @endif
                        <div >
                            <form action="{{route('save.review')}}" method="post">
                                @csrf
                                <label for="new_review">เพิ่มรีวิวของคุณ</label>
                                <textarea type="text" id="new_review" class="form-control" name="new_review" rows="3"></textarea>
                                <input type="hidden" value="{{$shop->id}}" name="shop_id">
                                <div class="row" style="margin-top: 0.8rem">
                                    <div class="col-md-6">
                                        <div id="round-enabled"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-cyan btn-rounded btn-sm text-white waves-light waves-effect float-right"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script src="{{asset('libs/raty-js/lib/jquery.raty.js')}}"></script>
    <script src="{{asset('extra-libs/raty/rating-init.js')}}"></script>
    <script src="{{asset('libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('libs/magnific-popup/meg.init.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>

    <script>
        var placeLat = '{!! $shop->lat !!}';
        var placeLng = '{!! $shop->lng !!}';
        var mapMarker;

        $(document).ready(function () {
           showMarker();
            $('#round-enabled').raty({
                score: 0
            });
        });

        function showMarker() {
            var iconPlace = {
                url: '{{ URL::asset('images/MapPointer/place_star.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var mapholder = document.getElementById('map');
            mapholder.style.height = '200px';
            mapholder.style.width = 'auto';

            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(placeLat, placeLng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);

            mapMarker = new google.maps.Marker({
                position: new google.maps.LatLng(placeLat, placeLng),
                map: map,
                icon: iconPlace,
                animation: google.maps.Animation.BOUNCE
            });
        }
    </script>
@stop