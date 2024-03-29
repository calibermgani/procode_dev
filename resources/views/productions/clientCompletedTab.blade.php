@extends('layouts.app3')
@section('content')

                <div class="card card-custom custom-card">
                    <div class="card-body p-0">
                        @php
                             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail']['user_hrdetails'] &&  Session::get('loginDetails')['userDetail']['user_hrdetails']['current_designation']  !=null ? Session::get('loginDetails')['userDetail']['user_hrdetails']['current_designation']: "";
                            //$encodedId = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(Str::lower($databaseConnection));
                        @endphp
                        <div class="card-header border-0 px-4">
                            <div class="row">
                                <div class="col-md-6">
                                {{-- <span class="svg-icon svg-icon-primary svg-icon-lg ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" fill="currentColor"
                                        class="bi bi-arrow-left project_header_row" viewBox="0 0 16 16"
                                        style="width: 1.05rem !important;color: #000000 !important;margin-left: 4px !important;">
                                        <path fill-rule="evenodd"
                                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                                    </svg>
                                </span> --}}
                                <span class="project_header" style="margin-left: 4px !important;">Practice List</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" style="justify-content: flex-end;margin-right:1.4rem">
                                        <div class="outside float-right"  href="javascript:void(0);"></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                        <div class="wizard wizard-4 custom-wizard" id="kt_wizard_v4" data-wizard-state="step-first"
                            data-wizard-clickable="true" style="margin-top:-2rem !important">
                            <div class="wizard-nav">
                                <div class="wizard-steps">
                                    <!--begin:: Tab Menu View -->
                                    <div class="wizard-step mb-0 one" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Assigned</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab">
                                                        {{ $assignedCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $assignedCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 two" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Pending</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab">
                                                        {{ $pendingCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $pendingCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 three" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Hold</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab">
                                                        {{ $holdCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $holdCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 four" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Completed</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab-selected">
                                                        {{ $completedCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $completedCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 five" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Rework</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab">
                                                        {{ $reworkCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $reworkCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($empDesignation == "Administrator" || strpos($empDesignation, 'Manager') !== false || strpos($empDesignation, 'VP') !== false || strpos($empDesignation, 'Leader') !== false || strpos($empDesignation, 'Team Lead') !== false || strpos($empDesignation, 'CEO') !== false || strpos($empDesignation, 'Vice') !== false)
                                        <div class="wizard-step mb-0 six" data-wizard-type="done">
                                            <div class="wizard-wrapper py-2">
                                                <div class="wizard-label p-2 mt-2">
                                                    <div class="wizard-title" style="display: flex; align-items: center;">
                                                        <h6 style="margin-right: 5px;">Duplicate</h6>
                                                        {{-- <div class="rounded-circle code-badge-tab">
                                                            {{ $duplicateCount }}
                                                        </div> --}}
                                                        @include('CountVar.countRectangle', ['count' => $duplicateCount])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card card-custom custom-top-border">
                            <div class="card-body py-0 px-7">
                                {{-- <input type="hidden" value={{ $databaseConnection }} id="dbConnection">
                                <input type="hidden" value={{ $encodedId }} id="encodeddbConnection"> --}}
                                <input type="hidden" value={{ $clientName }} id="clientName">
                                <input type="hidden" value={{ $subProjectName }} id="subProjectName">
                                <div class="table-responsive pt-5 pb-5 clietnts_table">
                                    <table class="table table-separate table-head-custom no-footer dtr-column "
                                        id="client_completed_list">
                                        {{-- <thead>

                                            <tr>
                                                @if ($completedProjectDetails->contains('key', 'value'))
                                                    @foreach ($completedProjectDetails[0]->getAttributes() as $columnName => $columnValue)
                                                        @php
                                                            $columnsToExclude = ['id','QA_emp_id', 'created_at', 'updated_at', 'deleted_at'];
                                                        @endphp
                                                        @if (!in_array($columnName, $columnsToExclude))
                                                            <th style="width:12%"><input type="hideen"
                                                                    value={{ $columnValue }}>{{ str_replace(['_', '_or_'], [' ', '/'], ucwords(str_replace('_', ' ', $columnValue))) }}
                                                            </th>
                                                        @endif
                                                    @endforeach
                                                    <th style="width:16%">Action</th>
                                                @else
                                                    @foreach ($columnsHeader as $columnName => $columnValue)
                                                        <th style="width:12%"><input type="hidden"
                                                                value={{ $columnValue }}>
                                                            {{ ucwords(str_replace(['_or_', '_'], ['/', ' '], $columnValue)) }}
                                                        </th>
                                                    @endforeach
                                                @endif
                                                <th style="width:16%">Action</th>
                                            </tr>


                                        </thead> --}}
                                        <thead>
                                            @if (!empty($columnsHeader))
                                                <tr>
                                                    <th style="width:16%">Action</th>
                                                    @foreach ($columnsHeader as $columnName => $columnValue)
                                                        @if ($columnValue != 'id')
                                                            <th style="width:12%"><input type="hidden"
                                                                    value={{ $columnValue }}>
                                                                {{ ucwords(str_replace(['_else_', '_'], ['/', ' '], $columnValue)) }}
                                                            </th>
                                                        @else
                                                            <th style="width:12%;display:none"><input type="hidden"
                                                                    value={{ $columnValue }}>
                                                                {{ ucwords(str_replace(['_else_', '_'], ['/', ' '], $columnValue)) }}
                                                            </th>
                                                        @endif
                                                    @endforeach

                                                </tr>
                                            @endif

                                        </thead>
                                        <tbody>
                                            @if (isset($completedProjectDetails))
                                                @foreach ($completedProjectDetails as $data)
                                                    <tr>
                                                        <td>    <button class="task-start clickable-view"
                                                            title="View"><i
                                                            class="fa far fa-eye text-eye icon-circle1 mt-0"></i></button></td>
                                                        @foreach ($data->getAttributes() as $columnName => $columnValue)
                                                            @php
                                                                $columnsToExclude = ['QA_emp_id', 'created_at', 'updated_at', 'deleted_at'];
                                                            @endphp
                                                            @if (!in_array($columnName, $columnsToExclude))
                                                                {{-- <td style="max-width: 300px;white-space: normal;">
                                                                    @if (str_contains($columnValue, '-') && strtotime($columnValue))
                                                                        {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                    @else
                                                                        @if ($columnName == 'claim_status' && str_contains($columnValue, 'CE_'))
                                                                            {{ str_replace('CE_', '', $columnValue) }}
                                                                        @else
                                                                            {{ $columnValue }}
                                                                        @endif
                                                                    @endif
                                                                </td> --}}
                                                                @if ($columnName != 'id')
                                                                <td style="max-width: 300px;
                                                                white-space: normal;">
                                                                    @if (str_contains($columnValue, '-') && strtotime($columnValue))
                                                                        {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                    @else
                                                                        @if ($columnName == 'claim_status' && str_contains($columnValue, 'CE_'))
                                                                            {{ str_replace('CE_', '', $columnValue) }}
                                                                        @else
                                                                            {{ $columnValue }}
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            @else
                                                                <td style="display:none;max-width: 300px;
                                                                white-space: normal;" id="table_id">
                                                                    @if (str_contains($columnValue, '-') && strtotime($columnValue))
                                                                        {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                    @else
                                                                        {{ $columnValue }}
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade modal-first" id="myModal_view" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
                        @if ($popUpHeader != null)
                            <div class="modal-dialog">
                                @php
                                    $clientName = App\Http\Helper\Admin\Helpers::projectName(
                                        $popUpHeader->project_id,
                                    );
                                    $practiceName = App\Http\Helper\Admin\Helpers::subProjectName(
                                        $popUpHeader->project_id,
                                        $popUpHeader->sub_project_id,
                                    );
                                    $projectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                        $popUpHeader->project_id,
                                        'encode',
                                    );
                                    $subProjectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                        $popUpHeader->project_id,
                                        'encode',
                                    );

                                @endphp


                                    <div class="modal-content" style="margin-top: 7rem">
                                        <div class="modal-header" style="background-color: #139AB3;height: 84px">

                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <!-- Round background for the first letter of the project name -->
                                                    <div class="rounded-circle bg-white text-black mr-2" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;font-weight;bold">
                                                        <span>{{ strtoupper(substr($clientName->project_name, 0, 1)) }}</span>
                                                    </div>&nbsp;&nbsp;
                                                    <div>
                                                        <!-- Project name -->
                                                        <h4 class="modal-title mb-0" id="myModalLabel" style="color: #ffffff;">
                                                            {{ ucfirst($clientName->project_name) }}
                                                        </h4>
                                                        <!-- Sub project name -->
                                                        <h6 style="color: #ffffff;font-size:1rem;">{{ ucfirst($practiceName->sub_project_name) }}</h6>
                                                    </div>&nbsp;&nbsp;
                                                    <!-- Oval background for project status -->
                                                    <div class="bg-white rounded-pill px-2 text-black" style="margin-bottom: 2rem;margin-left:2.2px;font-size:10px;font-weight:500;background-color:#E9F3FF;color:#139AB3;">
                                                        <span id="title_status"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="col-md-8 d-flex justify-content-end">
                                            <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Reference</a>
                                            <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">MOM</a>
                                            <button type="button" class="btn btn-black-white mr-3" id="sop_click" style="padding: 0.35rem 1rem;">SOP</button>
                                            <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Custom</a>
                                        </div>

                                            <button type="button" class="close comment_close" data-dismiss="modal"
                                                aria-hidden="true" style="color:#ffffff !important">&times;</button>

                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-3" data-scroll="true" data-height="400">
                                                    <h6 class="title-h6">Basic Information</h6>&nbsp;&nbsp;
                                                    @if (count($popupNonEditableFields) > 0)
                                                        @php $count = 0; @endphp
                                                        <input type="hidden" name="idValue">
                                                        @foreach ($popupNonEditableFields as $data)
                                                        @php
                                                        $columnName = Str::lower(
                                                            str_replace(
                                                                [' ', '/'],
                                                                ['_', '_else_'],
                                                                $data->label_name,
                                                            ),
                                                        );
                                                        $inputType = $data->input_type;
                                                        $options =
                                                            $data->options_name != null
                                                                ? explode(',', $data->options_name)
                                                                : null;
                                                    @endphp

                                                        <label
                                                            class="col-md-12">{{ $data->label_name }}
                                                        </label>
                                                        <input type="hidden" name="{{ $columnName }}">

                                                        <label class="col-md-12 pop-non-edt-val"
                                                            id={{ $columnName }}>
                                                        </label>
                                                        <hr style="margin-left:1rem">
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="col-md-9" style="border-left: 1px solid #ccc;" data-scroll="true" data-height="400">
                                                    <h6 class="title-h6">Form</h6>&nbsp;&nbsp;
                                                    @if (count($popupEditableFields) > 0)
                                                        @php $count = 0; @endphp
                                                        @foreach ($popupEditableFields as $key => $data)
                                                        @php
                                                        $labelName = $data->label_name;
                                                        $columnName = Str::lower(
                                                            str_replace([' ', '/'], ['_', '_else_'], $data->label_name),
                                                        );

                                                    @endphp
                                                    @if ($count % 2 == 0)
                                                        <div class="row" id={{ $columnName }}>
                                                    @endif
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-md-12">
                                                                    {{ $labelName }}
                                                                </label>
                                                                <label class="col-md-12 pop-non-edt-val"
                                                                id={{ $columnName }}>
                                                            </label>

                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    @php $count++; @endphp
                                                    @if ($count % 2 == 0 || $loop->last)
                                                    </div>
                                                    @endif
                                                        @endforeach
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="form-group row" style="margin-left: -2rem">
                                                            <label class="col-md-12">
                                                                Claim Status
                                                            </label>
                                                            <label class="col-md-12 pop-non-edt-val"
                                                            id="claim_status">
                                                        </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button class="btn btn-light-danger float-right" id="close_assign" tabindex="10" type="button" data-dismiss="modal">
                                                    <span>
                                                        <span>Close</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                        @endif
                </div>
                </div>

@endsection
<style>
    /* Increase modal width */
    /* #myModal_view .modal-dialog {
        max-width: 800px;
    }
    #myModal_view .modal-body label {
        margin-bottom: 5px;
    }
    #myModal_view .modal-body input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    } */

    /* .dt-buttons {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 1000;
  } */


    .dropdown-item.active {
        color: #ffffff;
        text-decoration: none;
        background-color: #888a91;
    }
</style>
@push('view.scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>

        $(document).ready(function() {
            var table = $("#client_completed_list").DataTable({
                processing: true,
                clientSide: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
                scrollCollapse: true,
                scrollX: true,
                "initComplete": function(settings, json) {
                    $('body').find('.dataTables_scrollBody').addClass("scrollbar");
                },
                language: {
                    "search": '',
                    "searchPlaceholder": "   Search",
                },
                buttons: [{
                    "extend": 'excel',
                    "text": `<span data-dismiss="modal" data-toggle="tooltip" data-placement="left" data-original-title="Export" style="font-size:13px"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" fill="currentColor" class="bi bi-box-arrow-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z"/><path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708z"/>
                             </svg>&nbsp;&nbsp;&nbsp;<span>Export</span></span>`,
                    "className": 'btn btn-primary-export text-white',
                    "title": 'PROCODE',
                    "filename": 'procode_report_',
                }],
                dom: "B<'row'<'col-md-12'f><'col-md-12't>><'row'<'col-md-5 pt-2'i><'col-md-7 pt-2'p>>"
            })
            table.buttons().container()
                .appendTo('.outside');
                $('.dataTables_filter').addClass('pull-left');

                var clientName = $('#clientName').val();
                var subProjectName = $('#subProjectName').val();
                $(document).on('click', '.clickable-view', function(e) {
                    // var record_id = $(this).closest('tr').find('td:eq(0)').text();
                    // var record_id = $(this).closest('tr').find('td:eq(1)').text();
                    var record_id =  $(this).closest('tr').find('#table_id').text();console.log(record_id,'record_id');
                    var $row = $(this).closest('tr');
                    var tdCount = $row.find('td').length;
                    var thCount = tdCount - 1;

                var headers = [];
                $row.closest('table').find('thead th input').each(function() {
                    if ($(this).val() != undefined) {
                        headers.push($(this).val());
                    }
                });
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                  });

                    $.ajax({
                        url: "{{ url('client_completed_datas_details') }}",
                        method: 'POST',
                        data: {
                            record_id: record_id,
                            clientName: clientName,
                            subProjectName: subProjectName
                        },
                        success: function(response) {
                            if (response.success == true) {

                                $('#myModal_view').modal('show');
                                handleClientData(response.clientData,headers);
                            } else {
                                $('#myModal_view').modal('hide');
                                js_notification('error', 'Something went wrong');
                            }
                        },
                    });
                    function handleClientData(clientData,headers) {
                        console.log(clientData, 'clientData',headers,clientData.id);

                    $.each(headers, function(index, header) {
                        value = clientData[header];
                        $('label[id="' + header + '"]').html("");
                    if (/_el_/.test(value)) {
                        var values = value.split('_el_');
                        var formattedDatas = [];
                        values.forEach(function(data, index) {
                            // if (data.includes('-')) {
                            //     var formattedData = formatDate(data);
                            // } else {
                            //     var formattedData = data;
                            // }
                            // var span = $('<span>').addClass('date-label').text(formattedData);
                            var circle = $('<span>').addClass('circle');
                            var span = $('<span>').addClass('date-label').text(data);
                                span.prepend(circle);
                                   formattedDatas.push(span);
                        }); console.log(formattedDatas,'formattedDatas');
                        formattedDatas.forEach(function(span, index) {

                            $('label[id="' + header + '"]').append(span);
                            // Add comma after each span except the last one

                        });
                    } else {
                        if (header === 'claim_status' && value.includes('CE_')) {
                                value = value.replace('CE_', '');
                        }

                       $('label[id="' + header + '"]').text(value);
                    }

                    function formatDate(dateString) {
                        var parts = dateString.split('-');
                        var formattedDatas = parts[1] + '/' + parts[2] + '/' + parts[0];
                        return formattedDatas;
                    }
                        // $('label[id="' + header + '"]').text(value);
                    console.log("Index: " + index + ", Value: " + header,value);
                  });

               }
            });
            // var encodedProjectId = $('#encodeddbConnection').val();

            $(document).on('click', '.one', function() {
                window.location.href = baseUrl + 'projects_assigned/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()[
                        "parent"] +
                    "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.two', function() {
                window.location.href = baseUrl + 'projects_pending/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.three', function() {
                window.location.href = baseUrl + 'projects_hold/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.four', function() {
                window.location.href = "{{ url('#') }}";
            })
            $(document).on('click', '.five', function() {
                window.location.href = baseUrl + 'projects_rework/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.six', function() {
                window.location.href = baseUrl + 'projects_duplicate/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
        })
    </script>
@endpush
