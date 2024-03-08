@extends('layouts.app3')

@section('content')


<div class="container">
    <div class="row">
        <!-- First section -->
        <div class="col-md-6">
            <!-- First section card -->
            <div class="card">
                <div class="card-body">
                    <!-- First section left side -->
                    <div class="row">
                        <!-- Five small cards showing status -->
                        <div class="col-2">
                            <div class="card bg-primary text-white">Card 1</div>
                        </div>
                        <div class="col-2">
                            <div class="card bg-success text-white">Card 2</div>
                        </div>
                        <div class="col-2">
                            <div class="card bg-warning text-white">Card 3</div>
                        </div>
                        <div class="col-2">
                            <div class="card bg-danger text-white">Card 4</div>
                        </div>
                        <div class="col-2">
                            <div class="card bg-info text-white">Card 5</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- First section right side card -->
            <div class="card">
                <div class="card-body">
                    <!-- Flow chart -->
                    <img src="flowchart.png" alt="Flow chart" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <!-- Second section -->
        <div class="col-md-6">
            <!-- Second section left card -->
            <div class="card">
                <div class="card-body">
                    <!-- Table 1 -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Data 1</td>
                                <td>Data 2</td>
                                <td>Data 3</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Second section right card -->
            <div class="card">
                <div class="card-body">
                    <!-- Table 2 -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Data 1</td>
                                <td>Data 2</td>
                                <td>Data 3</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
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
