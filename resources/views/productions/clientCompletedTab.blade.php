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
                                    <div class="wizard-step mb-0 one" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Assigned</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 two" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                    style="display: inline-block;max-width: 180px; white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h6>Pending</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 three" data-wizard-type="done">
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
                                    <div class="wizard-step mb-0 five" data-wizard-type="done">
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
                                        <div class="wizard-step mb-0 six" data-wizard-type="done">
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

                        <div class="card card-custom card-shadowless rounded-top-0">
                            <div class="card-body py-0 px-7">
                                <input type="hidden" value={{ $databaseConnection }} id="dbConnection">
                                <input type="hidden" value={{ $encodedId }} id="encodeddbConnection">
                                <div class="table-responsive pt-5">
                                    <table class="table table-separate table-head-custom no-footer dtr-column "
                                        id="client_completed_list">
                                        <thead>
                                            <tr>
                                                <th style="width:15%">Ticket Number</th>
                                                <th style="width:15%">Patient Name</th>
                                                <th style="width:15%">Patient Id</th>
                                                <th style="width:15%">DOB</th>
                                                <th style="width:15%">DOS</th>
                                                <th style="width:15%">Coders E/M ICD 10</th>
                                                <th style="width:15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($completedProjectDetails))
                                                @foreach ($completedProjectDetails as $data)
                                                    <tr class="clickable-row">
                                                        <td>
                                                            {{ $data->ticket_number }}</td>
                                                        <td>
                                                            {{ $data->patient_name }}</td>
                                                        <td>
                                                            {{ $data->patient_id }}</td>
                                                        <td>
                                                            {{ date('m/d/Y', strtotime($data->dob)) }}</td>
                                                        <td>
                                                            {{ date('m/d/Y', strtotime($data->dos)) }}</td>
                                                        <td>
                                                            {{ $data->coders_em_icd_10 }}</td>
                                                        <td>
                                                            <span class="svg-icon svg-icon-success mr-2 question_play"
                                                                title="play">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <circle fill="#000000" opacity="0.3" cx="12"
                                                                            cy="12" r="9" />
                                                                        <path
                                                                            d="M11.1582329,15.8732969 L15.1507272,12.3908445 C15.3588289,12.2093278 15.3803803,11.8934798 15.1988637,11.6853781 C15.1842721,11.6686494 15.1685826,11.652911 15.1518994,11.6382673 L11.1594051,8.13385466 C10.9518699,7.95169059 10.6359562,7.97225796 10.4537922,8.17979317 C10.3737213,8.27101604 10.3295679,8.388251 10.3295679,8.5096304 L10.3295679,15.4964955 C10.3295679,15.7726378 10.5534255,15.9964955 10.8295679,15.9964955 C10.950411,15.9964955 11.0671652,15.9527307 11.1582329,15.8732969 Z"
                                                                            fill="#000000" />
                                                                    </g>
                                                                </svg>
                                                            </span>

                                                            <a class="pt-1" data-toggle="tooltip" title="View"
                                                                href=""><i
                                                                    class="fa far fa-eye text-success icon-circle1 mt-0"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
            $('#client_completed_list').dataTable({
                processing: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
            });
            $(document).on('click', '.clickable-row', function(e) {
                $('#myModal_status').modal('show');
            });
            var encodedProjectId = $('#encodeddbConnection').val();
            $(document).on('click', '.one', function() {
                window.location.href = baseUrl + 'projects_assigned/' + encodedProjectId + "?parent=" +
                    getUrlVars()[
                        "parent"] +
                    "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.two', function() {
                window.location.href = baseUrl + 'projects_pending/' + encodedProjectId + "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.three', function() {
                window.location.href = baseUrl + 'projects_hold/' + encodedProjectId + "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.four', function() {
                window.location.href = "{{ url('#') }}";
            })
            $(document).on('click', '.five', function() {
                window.location.href = baseUrl + 'projects_rework/' + encodedProjectId + "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.six', function() {
                window.location.href = baseUrl + 'projects_duplicate/' + encodedProjectId + "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];
            })
        })
    </script>
@endpush
