@extends('layouts.dashboard')

@section('title')
    @include('layouts.inc.title',['title'=>"Dashboard"])
@endsection

@section('customStyles')

    <style>

        .bg {
            background-color: #43c0b1;
            font-weight: bold;
            color: white;

        }


    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-9">

                <marquee width="100%" direction="left" scrollamount="12">
                    <h1 style="font-size: 55pt; font-weight: bold ; color: black">N O W &nbsp S E R V I N G! &nbsp&nbsp
                        N O W &nbsp S E R V I N G! &nbsp&nbsp N O W &nbsp S E R V I N G! &nbsp&nbsp N O W &nbsp S E R V
                        I N G!&nbsp&nbsp</h1>
                </marquee>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @include('dashboard.nowserving');
            </div>
            <div class="col-md-4">
                @include('dashboard.adds')
            </div>
        </div>
    </div>





@endsection

@section('customScripts')
    <script>
        $(document).ready(function () {


            function playsound() {

                var audio = {};
                audio["walk"] = new Audio();
                audio["walk"].src = "{{asset('/public/storage/music_1.mp3')}}";
                audio["walk"].play();
            }

            function updateplaysound(id) {


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{url('/dashboard/updateplaysound')}}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, id: id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */

                    success: function (data1) {
                        console.log(data1);
                    }
                });

            }

            function checkdbupdate() {


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                setInterval(function () {
                    $.ajax({
                        /* the route pointing to the post function */
                        url: '{{url('/dashboard/checkdbupdate')}}',
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */

                        success: function (data) {

                            var officedomid = "#officename" + data['office_id'];
                            var prioritynumdom = "#prioritynum" + data['office_id'];

                            console.log(data);

                            if (data['playsound'] == 1 && data['nowserving'] == 1) {

                                $(prioritynumdom).html(data['priority_no']);
                                $(officedomid).addClass("bg");
                                playsound();
                            }

                            // updateplaysound(data['id']);

                        }

                    });
                }, 1000); // Do this every 5 seconds
            }

            checkdbupdate();


        });
    </script>

@endsection