@extends('layouts.app3')
@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Clients</h5>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-custom" style="">
        <div class="card-header border-0 px-4">
            <div class="card-title">
                <span class="text-muted font-weight-bold font-size-lg flex-grow-1">
                    <span class="svg-icon svg-icon-primary svg-icon-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path
                                    d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z"
                                    fill="#000000"></path>
                            </g>
                        </svg>
                    </span>
                    <span style="color:#0e969c">Client List</span>
                </span>
            </div>
            <div class="card-toolbar d-inline float-right mt-3">
                <div class="outside" href="javascript:void(0);"></div>
            </div>
        </div>

        <div class="card-body mt-0 pt-0 pb-0 px-0">

            <div class="card card-custom" style="border-radius:0px 0px 10px 10px" id="page-loader">
                <div class="card-body pt-4 pb-0 px-5">
                    <div class="mb-0">
                        <div class="table-responsive pb-4">
                            <table class="table table-separate table-head-custom no-footer dtr-column " id="clients_list">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Client Name</th>
                                        <th>Assigned</th>
                                        <th>Completed</th>
                                        <th>Pending</th>
                                        <th>On Hold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $encodedId = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(1);
                                        $encodeProjectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID('aig');
                                    @endphp
                                    @if (isset($projects))
                                        @foreach ($projects as $data)
                                            <tr>
                                                <td class="details-control"></td>
                                                <td>{{ $data->project_name }} <input type="hidden"
                                                        value={{ $data->id }}></td>
                                                <td>10</td>
                                                <td>20</td>
                                                <td>30</td>
                                                <td>40</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    {{-- <tr class="clickable-row">
                                         <td class="details-control"><input type="hidden" value={{ $encodedId }}></td>
                                        <td>AIG <input type="hidden" value={{ $encodeProjectName }}></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr class="clickable-row">
                                        <td class="details-control"></td>
                                        <td>Ssioux <input type="hidden" value = ""></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr class="clickable-row">
                                        <td class="details-control"></td>
                                        <td>Eureka <input type="hidden" value = ""></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr class="clickable-row">
                                        <td class="details-control"></td>
                                        <td>MEC <input type="hidden" value = ""></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .table thead th {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    td.details-control {
        background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_close.png') no-repeat center center;
    }

    .leave_color {
        background: #ff00000f;
    }

    .border-none {
        border: none !important
    }

    #myDIV2 {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    table#project_financess tr th {
        width: 10% !important;
    }

    table#project_financess tr {
        white-space: nowrap;
    }

    .inv_head tr th {
        background: #d6edee;
        color: #0e96a9 !important;
        font-size: 12px !important;
        padding: 9 !important;
    }

    .inv_head tr {
        border: 1px solid #ECF0F3
    }

    .inv_head tr {
        border-bottom: 1px solid #ECF0F3;
    }

    .table.table-separate .inv_lft th:last-child,
    .table.table-separate td:last-child {
        padding-right: 10 !important;
    }
</style>
@push('view.scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $("#clients_list").DataTable({
                processing: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
                columnDefs: [{
                    className: 'details-control',
                    targets: [0],
                    orderable: false,
                }, ],
                responsive: true

            })
            table.buttons().container()
                .appendTo('.outside');

            $('#clients_list tbody').on('click', 'td.details-control', function() {
                var client_id = $(this).closest('tr').find('td:eq(1) input').val();
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('sub_projects') }}",
                        data: {
                            project_id: client_id,
                        },
                        success: function(res) {
                            console.log(res, 'res');
                            subProjects = res.subprojects;
                            row.child(format(row.data(), subProjects)).show();
                            tr.addClass('shown');
                        },
                        error: function(jqXHR, exception) {}
                    });

                }
            });


            function format(data, subProjects) {
                var html =
                    '<table class="inv_head" cellpadding="5" cellspacing="0" border="0" style="width:100%" id="production_entry_sub" class="production_entry_sub">' +
                    '<tr><th></th><th>Sub Project</th><th>Assigned</th> <th>Pending</th> <th>On Hold</th><th>Completed</th> </tr>';
                $.each(subProjects, function(index, val) {
                    console.log(val, 'val');
                    html +=
                        '<tbody><tr class="clickable-row">' +
                        '<td><input type="hidden" value=' + val.client_name.project_name + '></td>' +
                        '<td>' + val.sub_project_name + '</td>' +
                        '<td>' + '10' + '</td>' +
                        '<td>' + '20' + '</td>' +
                        '<td>' + '30' + '</td>' +
                        '<td>' + '50' + '</td>' +
                        '</tr></tbody>';
                });
                html += '</table>';
                return html;
                return '<div>Details for ' + data[0] + '</div>';
            }

            $(document).on('click', '.clickable-row', function(e) {

                // var client_name = $(this).closest('tr').find('td:eq(1)').text();
                // var id = $(this).closest('tr').find('td:eq(0)').text();
                // var encodedId = $(this).closest('tr').find('td:eq(0) input').val();
                var clientName = $(this).closest('tr').find('td:eq(0) input').val();
                var subProjectName = $(this).closest('tr').find('td:eq(1)').text();

                if (!clientName) {
                    console.error('encodedclientname is undefined or empty');
                    return;
                }

                // window.location.href = baseUrl + 'projects/' + encodedId + '/' + clientName + "?parent=" +
                //     getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
                window.location.href = baseUrl + 'projects_assigned/' + btoa(clientName) +'/'+btoa(subProjectName)+ "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];

            })
        })
    </script>
@endpush
