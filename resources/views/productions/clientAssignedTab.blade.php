@extends('layouts.app3')

@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Client Information</h5>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid p-0">
                <div class="card card-custom card-transparent">
                    <div class="card-body p-0">
                        @php
                            $empDesignation = Session::get('loginDetails') && Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] != null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : '';
                            $encodedId = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(Str::lower($databaseConnection));
                        @endphp
                        <div class="wizard wizard-4" id="kt_wizard_v4" data-wizard-state="step-first"
                            data-wizard-clickable="true">
                            <div class="wizard-nav">
                                <div class="wizard-steps">
                                    <!--begin:: Tab Menu View -->
                                    <div class="wizard-step mb-0 one" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Assigned</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 two" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Pending</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 three" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Hold</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 four" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 five" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Rework</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($empDesignation == 'Administrator')
                                        <div class="wizard-step mb-0 six" data-wizard-type="step">
                                            <div class="wizard-wrapper py-2">
                                                <div class="wizard-label p-2 mt-2">
                                                    <div class="wizard-title"
                                                        style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                        <h6>Duplicate</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card card-custom">
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
                                        <span style="color:#0e969c">Client Information</span>
                                    </span>
                                </div>
                                <div class="card-toolbar d-inline float-right mt-3">
                                    <div class="outside" href="javascript:void(0);"></div>
                                </div>
                            </div>
                            <div class="card-body py-0 px-7">
                                <input type="hidden" value={{ $databaseConnection }} id="dbConnection">
                                <input type="hidden" value={{ $encodedId }} id="encodeddbConnection">

                                <div class="table-responsive pt-5">
                                    <table class="table table-separate table-head-custom no-footer dtr-column "
                                        id="client_assigned_list">
                                        <thead>

                                            <tr>
                                                @foreach ($assignedProjectDetails[0]->getAttributes() as $columnName => $columnValue)
                                                    <th style="width:12%">{{ str_replace('_', ' ', $columnName) }}</th>
                                                @endforeach
                                                <th style="width:16%">Action</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @if (isset($assignedProjectDetails))
                                                @foreach ($assignedProjectDetails as $data)
                                                    <tr class="clickable-row"  style="{{ $data->ticket_number == 125 ? 'background-color: #f77a7a;' : '' }}">
                                                        @foreach ($data->getAttributes() as $columnName => $columnValue)
                                                        <td style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">{{ $columnValue }}</td>
                                                        @endforeach
                                                        <td
                                                            style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            @if ($data->ticket_number == 125)
                                                            @else
                                                                <span class="svg-icon svg-icon-success mr-2 question_play"
                                                                    title="play">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24px" height="24px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                height="24" />
                                                                            <circle fill="#000000" opacity="0.3"
                                                                                cx="12" cy="12" r="9" />
                                                                            <path
                                                                                d="M11.1582329,15.8732969 L15.1507272,12.3908445 C15.3588289,12.2093278 15.3803803,11.8934798 15.1988637,11.6853781 C15.1842721,11.6686494 15.1685826,11.652911 15.1518994,11.6382673 L11.1594051,8.13385466 C10.9518699,7.95169059 10.6359562,7.97225796 10.4537922,8.17979317 C10.3737213,8.27101604 10.3295679,8.388251 10.3295679,8.5096304 L10.3295679,15.4964955 C10.3295679,15.7726378 10.5534255,15.9964955 10.8295679,15.9964955 C10.950411,15.9964955 11.0671652,15.9527307 11.1582329,15.8732969 Z"
                                                                                fill="#000000" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <a class="pt-1" data-toggle="tooltip" title="View"
                                                                    href=""><i
                                                                        class="fa far fa-eye text-success icon-circle1 mt-0"></i></a>
                                                                        @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                {{-- @foreach ($assignedProjectDetails as $key => $data)
                                                    <tr class="clickable-row"
                                                        style="{{ $data->ticket_number == 125 ? 'background-color: #f77a7a;' : '' }}">
                                                        <td style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ $data->ticket_number }}</td>
                                                        <td style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ $data->patient_name }}</td>
                                                        <td style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ $data->patient_id }}</td>
                                                        <td
                                                            style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ date('m/d/Y', strtotime($data->dob)) }}</td>
                                                        <td
                                                            style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ date('m/d/Y', strtotime($data->dos)) }}</td>
                                                        <td
                                                            style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            {{ $data->coders_em_icd_10 }}</td>
                                                        <td
                                                            style="{{ $data->ticket_number == 125 ? 'color: #fff;' : '' }}">
                                                            @if ($data->ticket_number == 125)
                                                            @else
                                                                <span class="svg-icon svg-icon-success mr-2 question_play"
                                                                    title="play">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24px" height="24px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                height="24" />
                                                                            <circle fill="#000000" opacity="0.3"
                                                                                cx="12" cy="12" r="9" />
                                                                            <path
                                                                                d="M11.1582329,15.8732969 L15.1507272,12.3908445 C15.3588289,12.2093278 15.3803803,11.8934798 15.1988637,11.6853781 C15.1842721,11.6686494 15.1685826,11.652911 15.1518994,11.6382673 L11.1594051,8.13385466 C10.9518699,7.95169059 10.6359562,7.97225796 10.4537922,8.17979317 C10.3737213,8.27101604 10.3295679,8.388251 10.3295679,8.5096304 L10.3295679,15.4964955 C10.3295679,15.7726378 10.5534255,15.9964955 10.8295679,15.9964955 C10.950411,15.9964955 11.0671652,15.9527307 11.1582329,15.8732969 Z"
                                                                                fill="#000000" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <a class="pt-1" data-toggle="tooltip" title="View"
                                                                    href=""><i
                                                                        class="fa far fa-eye text-success icon-circle1 mt-0"></i></a>
                                                                        @endif
                                                        </td>

                                                   </tr>
                                                @endforeach --}}
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="modal fade" id="myModal_status" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Test Patient - 123</h4>
                                            <a href="" style="margin-left: 40rem;">SOP</a>
                                            <button type="button" class="close comment_close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>

                                        </div>
                                        <div class="modal-body">

                                            <div class="row" style="background-color: #ecf0f3;">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Ticket Number
                                                        </label>
                                                        <label class="col-md-5 col-form-label">123
                                                        </label>

                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Doctor
                                                        </label>
                                                        <label class="col-md-5 col-form-label">
                                                            Test
                                                        </label>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Patient Name
                                                        </label>
                                                        <label class="col-md-5 col-form-label">Test
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Patient Id
                                                        </label>
                                                        <label class="col-md-5 col-form-label">Test
                                                        </label>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">DOB
                                                        </label>
                                                        <label class="col-md-5 col-form-label">12/03/2023
                                                        </label>

                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">DOS
                                                        </label>
                                                        <label class="col-md-5 col-form-label">12/03/2023
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Coders E/M CPT
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('Coders_CPT', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Coders E/M ICD 10
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('Coders_icd_10', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Coders Procedure
                                                            CPT
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('Coders_pro_cpt', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Status
                                                        </label>
                                                        <div class="col-md-5">
                                                            <select id="statusDropdownValue" class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="Hold">Hold</option>
                                                                <option value="Clarification">Clarification</option>
                                                                <option value="Completed">Completed</option>
                                                                <option value="Pending">Pending</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Coders Procedure
                                                            ICD 10
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('Coders_pro_CPT', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Billers Audit CPT -
                                                            comments
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('billers_audit', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-7 col-form-label required">Billers Audit ICD
                                                        </label>
                                                        <div class="col-md-5">
                                                            {!! Form::text('billers_audit_icd', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label required">Remarks
                                                        </label>
                                                        <div class="col-md-8" style="margin-left: 2.5rem;">
                                                            {!! Form::textarea('Coders_pro_CPT', null, [
                                                                'class' => 'form-control',
                                                                'autocomplete' => 'none',
                                                                'rows' => 4,
                                                                'maxlength' => 250,
                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default comment_close"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                id="evidence_status_update">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Increase modal width */
    #myModal_status .modal-dialog {
        max-width: 800px;
        /* Adjust the width as needed */
    }

    /* Style for labels */
    #myModal_status .modal-body label {
        margin-bottom: 5px;
    }

    /* Style for textboxes */
    #myModal_status .modal-body input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

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
            var table = $("#client_assigned_list").DataTable({
                processing: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
                buttons: [{
                        "extend": 'excel',
                        "text": '<span data-dismiss="modal" data-toggle="tooltip" data-placement="left" data-original-title="Export"> <i class="fas fa-file-excel" style="font-size:14px;color: white"></i> Export</span>',
                        "className": 'btn btn-primary  btn-primary--icon text-white',
                        "title": 'PROCODE',
                        "filename": 'procode_report_',
                    }],
                    dom: "B<'row'<'col-md-12'f><'col-md-12't>><'row'<'col-md-5 pt-2'i><'col-md-7 pt-2'p>>"
            })
            table.buttons().container()
                .appendTo('.outside');

            $(document).on('click', '.clickable-row', function(e) {
                $('#myModal_status').modal('show');
            });
            var encodedProjectId = $('#encodeddbConnection').val();

            $(document).on('click', '.one', function() {
                window.location.href = "{{ url('#') }}";
            })

            $(document).on('click', '.two', function() {
                window.location.href = baseUrl + 'projects_pending/' + encodedProjectId + "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.three', function() {
                window.location.href = baseUrl + 'projects_hold/' + encodedProjectId + "?parent=" +
                    getUrlVars()["parent"] +
                    "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.four', function() {
                window.location.href = baseUrl + 'projects_completed/' + encodedProjectId + "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.five', function() {
                window.location.href = baseUrl + 'projects_rework/' + encodedProjectId + "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.six', function() {
                window.location.href = baseUrl + 'projects_duplicate/' + encodedProjectId + "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
        })
    </script>
@endpush
