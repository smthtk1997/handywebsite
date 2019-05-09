@extends('layouts.header')
@section('title','รายละเอียดสถานที่')
@section('style')
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
                                <p style="font-size: 15px">{{$work}}</p>
                            @endforeach
                        @endif
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
                            @else
                            <p class="text-info">ยังไม่มีรีวิวจากลูกค้า</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>

    <script>
        var placeLat = '{!! $shop->lat !!}';
        var placeLng = '{!! $shop->lng !!}';
        var mapMarker;

        $(document).ready(function () {
           showMarker();
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