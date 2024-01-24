@extends('layouts.app3')
@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="dashboard-head">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom card-stretch gutter-b" style="height: 450px">
                    <div data-scroll="true" data-height="400">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom card-stretch gutter-b" style="height: 450px">
                    <div data-scroll="true" data-height="400">
                        <div class="card-body px-5 py-0 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom card-stretch gutter-b" id="kt_todo_view" style="height: 450px">
                </div>
            </div>
        </div>
    @endsection
    <style>
        .notice_scroll {
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: darkgrey lightgrey;
        }

        .notice_scroll::-webkit-scrollbar {
            width: 4px;
            /*adjust the width as needed*/
        }

        .notice_scroll::-webkit-scrollbar-thumb {
            background-color: lightgrey;
            /* color of the thumb */
        }

        .notice_scroll::-webkit-scrollbar-track {
            background-color: #fff;
            /* color of the track */
        }
    </style>

