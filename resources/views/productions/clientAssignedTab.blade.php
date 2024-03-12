@extends('layouts.app3')
@section('content')

                <div class="card card-custom custom-card">
                    <div class="card-body p-0">
                        @php
                            $empDesignation =
                                Session::get('loginDetails') &&
                                Session::get('loginDetails')['userDetail'] &&
                                Session::get('loginDetails')['userDetail']['designation'] &&
                                Session::get('loginDetails')['userDetail']['designation']['designation'] != null
                                    ? Session::get('loginDetails')['userDetail']['designation']['designation']
                                    : '';
                            //$encodedId = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(Str::lower($databaseConnection));
                        @endphp
                        <div class="card-header border-0 px-4">
                            {{-- <div class="card-title">
                                <span class="project_header" style="margin-left: 4px !important;">Client Information</span>
                                <div class="outside float-right" href="javascript:void(0);"></div>
                            </div> --}}
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
                                    <span class="project_header" style="margin-left: 4px !important;">Client Information</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" style="justify-content: flex-end;margin-right:1.4rem">

                                        @if (isset($assignedDropDown) && !empty($assignedDropDown))
                                        <div class="col-lg-3 mb-lg-0 mb-6">

                                            <fieldset class="form-group mb-0 white-smoke-disabled">

                                                {!! Form::select('assignee_name', ['' => '--Select--'] + $assignedDropDown, null, [
                                                    'class' => 'form-control select2',
                                                    'id' => 'assigneeDropdown',
                                                    'style' => 'width: 100%;',
                                                    'disabled',
                                                ]) !!}
                                            </fieldset>
                                        </div>

                                    @endif
                                        &nbsp;&nbsp;
                                        <div class="outside" href="javascript:void(0);"></div>
                                    </div>
                                </div>
                          </div>
                        </div>
                        <div class="wizard wizard-4 custom-wizard" id="kt_wizard_v4" data-wizard-state="step-first"
                            data-wizard-clickable="true" style="margin-top:-2rem !important">
                            <div class="wizard-nav">
                                <div class="wizard-steps">
                                    <div class="wizard-step mb-0 one" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Assigned</h6>
                                                    <div class="rounded-circle code-badge-tab-selected">
                                                        {{ $assignedCount }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 two" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Pending</h6>
                                                    <div class="rounded-circle code-badge-tab">
                                                        {{ $pendingCount }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 three" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Hold</h6>
                                                    <div class="rounded-circle code-badge-tab">
                                                        {{ $holdCount }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 four" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Completed</h6>
                                                    <div class="rounded-circle code-badge-tab">
                                                        {{ $completedCount }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step mb-0 five" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title"
                                                style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Rework</h6>
                                                    <div class="rounded-circle code-badge-tab">
                                                        {{ $reworkCount }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($empDesignation == 'Administrator')
                                        <div class="wizard-step mb-0 six" data-wizard-type="step">
                                            <div class="wizard-wrapper py-2">
                                                <div class="wizard-label p-2 mt-2">
                                                    <div class="wizard-title"
                                                    style="display: flex; align-items: center;">
                                                        <h6 style="margin-right: 5px;">Duplicate</h6>
                                                        <div class="rounded-circle code-badge-tab">
                                                            {{ $duplicateCount }}
                                                        </div>
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
                                    {{-- <input type="hidden" value={{ $databaseConnection }} id="dbConnection"> --}}
                                    {{-- <input type="hidden" value={{ $encodedId }} id="encodeddbConnection"> --}}
                                    <input type="hidden" value={{ $clientName }} id="clientName">
                                    <input type="hidden" value={{ $subProjectName }} id="subProjectName">
                                    {{-- @if (isset($assignedDropDown) && !empty($assignedDropDown))
                                        <div class="col-lg-2 mb-lg-0 mb-6">
                                            <label>Assignee</label>
                                            <fieldset class="form-group mb-1">

                                                {!! Form::select('assignee_name', ['' => '--Select--'] + $assignedDropDown, null, [
                                                    'class' => 'form-control select2',
                                                    'id' => 'assigneeDropdown',
                                                    'style' => 'width: 100%;',
                                                    'disabled',
                                                ]) !!}
                                            </fieldset>
                                        </div> --}}
                                        {{-- <div class="form-group row" style="margin-left: 25rem;margin-bottom: -5rem;">
                                            <label style="margin-top: 17px;">Assignee</label>

                                            <fieldset class="col-md-2 col-form-label">
                                                {!! Form::select('assignee_name', ['' => '--Select--'] + $assignedDropDown, null, [
                                                    'class' => 'form-control select2',
                                                    'id' => 'assigneeDropdown',
                                                    'style' => 'width: 100%;',
                                                    'disabled',
                                                ]) !!}
                                            </fieldset>
                                        </div> --}}
                                    {{-- @endif --}}
                                    <div class="table-responsive pt-5 pb-5 clietnts_table">
                                        <table
                                            class="table table-separate table-head-custom no-footer dtr-column clients_list_filter"
                                            id="client_assigned_list">
                                            {{-- <thead>

                                                <tr>
                                                    @if ($assignedProjectDetails->contains('key', 'value'))
                                                        @foreach ($assignedProjectDetails[0]->getAttributes() as $columnName => $columnValue)
                                                            @php
                                                                $columnsToExclude = ['id', 'created_at', 'updated_at', 'deleted_at'];
                                                            @endphp
                                                            @if (!in_array($columnName, $columnsToExclude))
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
                                                            @endif
                                                        @endforeach
                                                        <th style="width:16%">Action</th>
                                                    @else
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
                                                        <th style="width:16%">Action</th>
                                                    @endif
                                                </tr>


                                            </thead> --}}
                                            <thead>
                                                @if (!empty($columnsHeader))
                                                    <tr>
                                                        @if (isset($assignedDropDown) && !empty($assignedDropDown))
                                                            <th style="width: 10px"><input type="checkbox" id="ckbCheckAll">
                                                            </th>
                                                        @endif
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
                                                        <th style="width:16%">Action</th>
                                                    </tr>
                                                @endif

                                            </thead>
                                            <tbody>
                                                @if (isset($assignedProjectDetails))
                                                    @foreach ($assignedProjectDetails as $data)
                                                        <tr>
                                                            @if (isset($assignedDropDown) && !empty($assignedDropDown))
                                                                <td><input type="checkbox" class="checkBoxClass" name='check[]'
                                                                        value="{{ $data->id }}">
                                                                </td>
                                                            @endif
                                                            @foreach ($data->getAttributes() as $columnName => $columnValue)
                                                                @php
                                                                    $columnsToExclude = [
                                                                        'QA_emp_id',
                                                                        'created_at',
                                                                        'updated_at',
                                                                        'deleted_at',
                                                                    ];
                                                                @endphp
                                                                @if (!in_array($columnName, $columnsToExclude))
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
                                                                        white-space: normal;">
                                                                            @if (str_contains($columnValue, '-') && strtotime($columnValue))
                                                                                {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                            @else
                                                                                {{ $columnValue }}
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            <td>
                                                                @if (empty($assignedDropDown))
                                                                    @if (empty($existingCallerChartsWorkLogs))
                                                                        {{-- <span
                                                                            class="svg-icon svg-icon-black-start mr-2 question_play clickable-row"
                                                                            title="play">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24"
                                                                                        height="24" />
                                                                                    <circle fill="#000000" opacity="0.3"
                                                                                        cx="12" cy="12" r="9" />
                                                                                    <path
                                                                                        d="M11.1582329,15.8732969 L15.1507272,12.3908445 C15.3588289,12.2093278 15.3803803,11.8934798 15.1988637,11.6853781 C15.1842721,11.6686494 15.1685826,11.652911 15.1518994,11.6382673 L11.1594051,8.13385466 C10.9518699,7.95169059 10.6359562,7.97225796 10.4537922,8.17979317 C10.3737213,8.27101604 10.3295679,8.388251 10.3295679,8.5096304 L10.3295679,15.4964955 C10.3295679,15.7726378 10.5534255,15.9964955 10.8295679,15.9964955 C10.950411,15.9964955 11.0671652,15.9527307 11.1582329,15.8732969 Z"
                                                                                        fill="#000000" />
                                                                                </g>
                                                                            </svg>

                                                                        </span> --}}
                                                                        <button class="task-start clickable-row"
                                                                            title="Start">Start</button>
                                                                    @elseif(in_array($data->id, $existingCallerChartsWorkLogs))
                                                                        {{-- <span
                                                                            class="svg-icon svg-icon-black-start mr-2 question_play clickable-row"
                                                                            title="play">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24"
                                                                                        height="24" />
                                                                                    <circle fill="#000000" opacity="0.3"
                                                                                        cx="12" cy="12" r="9" />
                                                                                    <path
                                                                                        d="M11.1582329,15.8732969 L15.1507272,12.3908445 C15.3588289,12.2093278 15.3803803,11.8934798 15.1988637,11.6853781 C15.1842721,11.6686494 15.1685826,11.652911 15.1518994,11.6382673 L11.1594051,8.13385466 C10.9518699,7.95169059 10.6359562,7.97225796 10.4537922,8.17979317 C10.3737213,8.27101604 10.3295679,8.388251 10.3295679,8.5096304 L10.3295679,15.4964955 C10.3295679,15.7726378 10.5534255,15.9964955 10.8295679,15.9964955 C10.950411,15.9964955 11.0671652,15.9527307 11.1582329,15.8732969 Z"
                                                                                        fill="#000000" />
                                                                                </g>
                                                                            </svg>
                                                                        </span> --}}
                                                                        <button class="task-start clickable-row"
                                                                            title="Start">Start</button>
                                                                    @endif
                                                                @endif
                                                                {{-- <a class="pt-1" data-toggle="tooltip" title="View"
                                                                    href=""><i
                                                                        class="fa far fa-eye text-eye icon-circle1 mt-0"></i></a> --}}
                                                                        <button class="task-start clickable-view"
                                                                        title="View"><i
                                                                        class="fa far fa-eye text-eye icon-circle1 mt-0"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal fade modal-first" id="myModal_status" tabindex="-1" role="dialog"
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
                                                        <div class="modal-header" style="background-color: #191C24;height: 84px">

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
                                                                    <div class="bg-white rounded-pill px-2 text-black" style="margin-bottom: 2rem;margin-left:2.2px;font-size:10px;font-weight:500;background-color:#E9F3FF;color:#5D84FF;">
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

                                                            {{-- <button type="button" class="close comment_close" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button> --}}

                                                        </div>
                                                        {!! Form::open([
                                                            'url' =>
                                                                url('project_store/' . $projectName . '/' . $subProjectName) .
                                                                '?parent=' .
                                                                request()->parent .
                                                                '&child=' .
                                                                request()->child,
                                                            'class' => 'form',
                                                            'id' => 'formConfiguration',
                                                            'enctype' => 'multipart/form-data',
                                                        ]) !!}
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-3" data-scroll="true" data-height="400">
                                                                    <h6 class="title-h6">Basic Information</h6>&nbsp;&nbsp;
                                                                    @if (count($popupNonEditableFields) > 0)
                                                                        @php $count = 0; @endphp
                                                                        <input type="hidden" name="idValue">
                                                                        @foreach ($popupNonEditableFields as $data)
                                                                        @php
                                                                        // $columnName = Str::lower(str_replace([' ', '/'], '_', $data->label_name));
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
                                                                        <input type="hidden" name="{{ $columnName }}[]">

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
                                                                        $inputType = $data->input_type;
                                                                        $options =
                                                                            $data->options_name != null ? explode(',', $data->options_name) : null;
                                                                        $associativeOptions = [];
                                                                        if ($options !== null) {
                                                                            foreach ($options as $option) {
                                                                                $associativeOptions[$option] = $option;
                                                                            }
                                                                            //$associativeOptions =  ['' => '-- Select --'] + $associativeOptions;
                                                                        }
                                                                    @endphp
                                                                    @if ($count % 2 == 0)
                                                                        <div class="row" id={{ $columnName }}>
                                                                    @endif
                                                                        {{-- <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-5 col-form-label {{ $data->field_type_2 == 'mandatory' ? 'required' : '' }}">
                                                                                    {{ $labelName }}
                                                                                </label>
                                                                                <div class="col-md-6">
                                                                                    @if ($options == null)
                                                                                        @if ($inputType != 'date_range')
                                                                                            {!! Form::$inputType($columnName . '[]', null, [
                                                                                                'class' => 'form-control pop-non-edt-val ' . $columnName,
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                'rows' => 3,
                                                                                                'id' => $columnName,
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @else
                                                                                            {!! Form::text($columnName . '[]', null, [
                                                                                                'class' => 'form-control pop-non-edt-val date_range daterange_' . $columnName,
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                'id' => 'date_range',
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($inputType == 'select')
                                                                                            {!! Form::$inputType($columnName . '[]', ['' => '-- Select --'] + $associativeOptions, null, [
                                                                                                'class' => 'form-control pop-non-edt-val ' . $columnName,
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                'id' => $columnName,
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @elseif ($inputType == 'checkbox')
                                                                                            <p id="check_p1"
                                                                                                style="display:none;color:red; margin-left: 3px;">Checkbox
                                                                                                is mandatory</p>
                                                                                            <div class="form-group row">
                                                                                                @for ($i = 0; $i < count($options); $i++)
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="checkbox-inline mt-2">
                                                                                                            <label class="checkbox pop-non-edt-val"
                                                                                                                style="word-break: break-all;">
                                                                                                                {!! Form::$inputType($columnName . '[]', $options[$i], false, [
                                                                                                                    'class' => $columnName,
                                                                                                                    'id' => $columnName,
                                                                                                                ]) !!}{{ $options[$i] }}
                                                                                                                <span></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endfor
                                                                                            </div>
                                                                                        @elseif ($inputType == 'radio')
                                                                                            <p id="radio_p1"
                                                                                                style="display: none; color: red; margin-left: 3px;">Radio
                                                                                                is mandatory</p>
                                                                                            <div class="form-group row">
                                                                                                @for ($i = 0; $i < count($options); $i++)
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="radio-inline mt-2">
                                                                                                            <label class="radio pop-non-edt-val"
                                                                                                                style="word-break: break-all;">
                                                                                                                {!! Form::$inputType($columnName, $options[$i], false, [
                                                                                                                    'class' => $columnName,
                                                                                                                ]) !!}{{ $options[$i] }}
                                                                                                                <span></span>
                                                                                                            </label>
                                                                                                        </div>

                                                                                                    </div>
                                                                                                @endfor

                                                                                            </div>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-form-label text-lg-right pt-0 pb-4">
                                                                                    <input type="hidden"
                                                                                        value="{{ $associativeOptions != null ? json_encode($associativeOptions) : null }}"
                                                                                        class="add_options">

                                                                                    @if ($data->field_type_1 == 'multiple')
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $labelName : '' }}"
                                                                                            class="add_labelName">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $columnName : '' }}"
                                                                                            class="add_columnName">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $inputType : '' }}"
                                                                                            class="add_inputtype">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? ($data->field_type_2 == 'mandatory' ? 'required' : '') : '' }}"
                                                                                            class="add_mandatory">
                                                                                        <i class="fa fa-plus icon-circle2 ml-1 add_more"
                                                                                            id="add_more_{{ $columnName }}"
                                                                                            style="{{ $data->field_type_1 == 'multiple' ? 'visibility: visible;' : 'visibility: hidden;' }}"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-12 {{ $data->field_type_2 == 'mandatory' ? 'required' : '' }}">
                                                                                    {{ $labelName }}
                                                                                </label>
                                                                                <div class="col-md-10">
                                                                                    @if ($options == null)
                                                                                        @if ($inputType != 'date_range')
                                                                                            {!! Form::$inputType($columnName . '[]', null, [
                                                                                                'class' => 'form-control ' . $columnName . ' white-smoke pop-non-edt-val',
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'cursor:pointer',
                                                                                                'rows' => 3,
                                                                                                'id' => $columnName,
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @else
                                                                                            {!! Form::text($columnName . '[]', null, [
                                                                                                'class' => 'form-control date_range daterange_' . $columnName . ' white-smoke pop-non-edt-val',
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'cursor:pointer',
                                                                                                'id' => 'date_range',
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($inputType == 'select')
                                                                                            {!! Form::$inputType($columnName . '[]', ['' => '-- Select --'] + $associativeOptions, null, [
                                                                                                'class' => 'form-control ' . $columnName . ' white-smoke pop-non-edt-val',
                                                                                                'autocomplete' => 'none',
                                                                                                'style' => 'cursor:pointer',
                                                                                                'id' => $columnName,
                                                                                                $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                            ]) !!}
                                                                                        @elseif ($inputType == 'checkbox')
                                                                                            <p id="check_p1"
                                                                                                style="display:none;color:red; margin-left: 3px;">Checkbox
                                                                                                is mandatory</p>
                                                                                            <div class="form-group row">
                                                                                                @for ($i = 0; $i < count($options); $i++)
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="checkbox-inline mt-2">
                                                                                                            <label class="checkbox pop-non-edt-val"
                                                                                                                style="word-break: break-all;">
                                                                                                                {!! Form::$inputType($columnName . '[]', $options[$i], false, [
                                                                                                                    'class' => $columnName,
                                                                                                                    'id' => $columnName,
                                                                                                                ]) !!}{{ $options[$i] }}
                                                                                                                <span></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endfor
                                                                                            </div>
                                                                                        @elseif ($inputType == 'radio')
                                                                                            <p id="radio_p1"
                                                                                                style="display: none; color: red; margin-left: 3px;">Radio
                                                                                                is mandatory</p>
                                                                                            <div class="form-group row">
                                                                                                @for ($i = 0; $i < count($options); $i++)
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="radio-inline mt-2">
                                                                                                            <label class="radio pop-non-edt-val"
                                                                                                                style="word-break: break-all;">
                                                                                                                {!! Form::$inputType($columnName, $options[$i], false, [
                                                                                                                    'class' => $columnName,
                                                                                                                ]) !!}{{ $options[$i] }}
                                                                                                                <span></span>
                                                                                                            </label>
                                                                                                        </div>

                                                                                                    </div>
                                                                                                @endfor

                                                                                            </div>
                                                                                        @endif
                                                                                    @endif

                                                                                </div>
                                                                                <div class="col-md-1 col-form-label pt-0 pb-4" style="margin-left: -1.3rem;">
                                                                                    <input type="hidden"
                                                                                        value="{{ $associativeOptions != null ? json_encode($associativeOptions) : null }}"
                                                                                        class="add_options">

                                                                                    @if ($data->field_type_1 == 'multiple')
                                                                                    <i class="fa fa-plus add_more"
                                                                                            id="add_more_{{ $columnName }}"
                                                                                            style="{{ $data->field_type_1 == 'multiple' ? 'visibility: visible;' : 'visibility: hidden;' }}"></i>
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $labelName : '' }}"
                                                                                            class="add_labelName">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $columnName : '' }}"
                                                                                            class="add_columnName">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? $inputType : '' }}"
                                                                                            class="add_inputtype">
                                                                                        <input type="hidden"
                                                                                            value="{{ $data->field_type_1 == 'multiple' ? ($data->field_type_2 == 'mandatory' ? 'required' : '') : '' }}"
                                                                                            class="add_mandatory">

                                                                                    @endif
                                                                                </div>
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
                                                                            <label class="col-md-12 required">
                                                                                Claim Status
                                                                            </label>
                                                                            <div class="col-md-10">
                                                                                {!! Form::Select(
                                                                                    'claim_status',
                                                                                    [
                                                                                        '' => '--Select--',
                                                                                        'CE_Inprocess' => 'Inprocess',
                                                                                        'CE_Pending' => 'Pending',
                                                                                        'CE_Completed' => 'Completed',
                                                                                        'CE_Clarification' => 'Clarification',
                                                                                        'CE_Hold' => 'Hold',
                                                                                    ],
                                                                                    null,
                                                                                    [
                                                                                        'class' => 'form-control white-smoke  pop-non-edt-val ',
                                                                                        'autocomplete' => 'none',
                                                                                        'id' => 'claim_status',
                                                                                        'style' => 'cursor:pointer',
                                                                                    ],
                                                                                ) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" style="justify-content: space-between;">


                                                                <p class="timer_1" aria-haspopup="true" aria-expanded="false" data-toggle="modal"
                                                                    data-target="#exampleModalCustomScrollable" style="margin-left: -2rem">

                                                                    <span title="Total hours">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22"
                                                                            fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                                                            <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z" />
                                                                            <path
                                                                                d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3" />
                                                                        </svg>
                                                                    </span><span id="elapsedTime" class="timer_2"></span>
                                                                </p>

                                                                <button type="submit" class="btn1" id="project_assign_save" style="margin-right: -2rem">Submit</button>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                        {{-- <div class="modal-body">
                                                                @if (count($popupNonEditableFields) > 0)
                                                                    @php $count = 0; @endphp
                                                                    <input type="hidden" name="idValue">
                                                                    @foreach ($popupNonEditableFields as $data)
                                                                        @php
                                                                            // $columnName = Str::lower(str_replace([' ', '/'], '_', $data->label_name));
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
                                                                        @if ($count % 2 == 0)
                                                                            <div class="row" style="background-color: #ecf0f3;">
                                                                        @endif
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-7 col-form-label">{{ $data->label_name }}
                                                                                </label>
                                                                                <input type="hidden" name="{{ $columnName }}[]">

                                                                                <label class="col-md-5 col-form-label"
                                                                                    id={{ $columnName }}>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        @php $count++; @endphp
                                                                        @if ($count % 2 == 0 || $loop->last)
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                    <hr style="width: 1px; height: 20px; display: inline-block;">
                                                                @endif
                                                                @if (count($popupEditableFields) > 0)
                                                                    @php $count = 0; @endphp
                                                                    @foreach ($popupEditableFields as $key => $data)
                                                                        @php
                                                                            $labelName = $data->label_name;
                                                                            $columnName = Str::lower(
                                                                                str_replace([' ', '/'], ['_', '_else_'], $data->label_name),
                                                                            );
                                                                            $inputType = $data->input_type;
                                                                            $options =
                                                                                $data->options_name != null ? explode(',', $data->options_name) : null;
                                                                            $associativeOptions = [];
                                                                            if ($options !== null) {
                                                                                foreach ($options as $option) {
                                                                                    $associativeOptions[$option] = $option;
                                                                                }
                                                                                //$associativeOptions =  ['' => '-- Select --'] + $associativeOptions;
                                                                            }
                                                                        @endphp
                                                                        @if ($count % 2 == 0)
                                                                            <div class="row" id={{ $columnName }}>
                                                                        @endif
                                                                            <div class="col-md-6">
                                                                                <div class="form-group row">
                                                                                    <label
                                                                                        class="col-md-5 col-form-label {{ $data->field_type_2 == 'mandatory' ? 'required' : '' }}">
                                                                                        {{ $labelName }}
                                                                                    </label>
                                                                                    <div class="col-md-6">
                                                                                        @if ($options == null)
                                                                                            @if ($inputType != 'date_range')
                                                                                                {!! Form::$inputType($columnName . '[]', null, [
                                                                                                    'class' => 'form-control ' . $columnName,
                                                                                                    'autocomplete' => 'none',
                                                                                                    'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                    'rows' => 3,
                                                                                                    'id' => $columnName,
                                                                                                    $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                                ]) !!}
                                                                                            @else
                                                                                                {!! Form::text($columnName . '[]', null, [
                                                                                                    'class' => 'form-control date_range daterange_' . $columnName,
                                                                                                    'autocomplete' => 'none',
                                                                                                    'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                    'id' => 'date_range',
                                                                                                    $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                                ]) !!}
                                                                                            @endif
                                                                                        @else
                                                                                            @if ($inputType == 'select')
                                                                                                {!! Form::$inputType($columnName . '[]', ['' => '-- Select --'] + $associativeOptions, null, [
                                                                                                    'class' => 'form-control ' . $columnName,
                                                                                                    'autocomplete' => 'none',
                                                                                                    'style' => 'background-color: #fff !important;cursor:pointer',
                                                                                                    'id' => $columnName,
                                                                                                    $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                                ]) !!}
                                                                                            @elseif ($inputType == 'checkbox')
                                                                                                <p id="check_p1"
                                                                                                    style="display:none;color:red; margin-left: 3px;">Checkbox
                                                                                                    is mandatory</p>
                                                                                                <div class="form-group row">
                                                                                                    @for ($i = 0; $i < count($options); $i++)
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="checkbox-inline mt-2">
                                                                                                                <label class="checkbox"
                                                                                                                    style="word-break: break-all;">
                                                                                                                    {!! Form::$inputType($columnName . '[]', $options[$i], false, [
                                                                                                                        'class' => $columnName,
                                                                                                                        'id' => $columnName,
                                                                                                                    ]) !!}{{ $options[$i] }}
                                                                                                                    <span></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endfor
                                                                                                </div>
                                                                                            @elseif ($inputType == 'radio')
                                                                                                <p id="radio_p1"
                                                                                                    style="display: none; color: red; margin-left: 3px;">Radio
                                                                                                    is mandatory</p>
                                                                                                <div class="form-group row">
                                                                                                    @for ($i = 0; $i < count($options); $i++)
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="radio-inline mt-2">
                                                                                                                <label class="radio"
                                                                                                                    style="word-break: break-all;">
                                                                                                                    {!! Form::$inputType($columnName, $options[$i], false, [
                                                                                                                        'class' => $columnName,
                                                                                                                    ]) !!}{{ $options[$i] }}
                                                                                                                    <span></span>
                                                                                                                </label>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    @endfor

                                                                                                </div>
                                                                                            @endif
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-form-label text-lg-right pt-0 pb-4">
                                                                                        <input type="hidden"
                                                                                            value="{{ $associativeOptions != null ? json_encode($associativeOptions) : null }}"
                                                                                            class="add_options">

                                                                                        @if ($data->field_type_1 == 'multiple')
                                                                                            <input type="hidden"
                                                                                                value="{{ $data->field_type_1 == 'multiple' ? $labelName : '' }}"
                                                                                                class="add_labelName">
                                                                                            <input type="hidden"
                                                                                                value="{{ $data->field_type_1 == 'multiple' ? $columnName : '' }}"
                                                                                                class="add_columnName">
                                                                                            <input type="hidden"
                                                                                                value="{{ $data->field_type_1 == 'multiple' ? $inputType : '' }}"
                                                                                                class="add_inputtype">
                                                                                            <input type="hidden"
                                                                                                value="{{ $data->field_type_1 == 'multiple' ? ($data->field_type_2 == 'mandatory' ? 'required' : '') : '' }}"
                                                                                                class="add_mandatory">
                                                                                            <i class="fa fa-plus text-eye icon-circle1 ml-1 add_more"
                                                                                                id="add_more_{{ $columnName }}"
                                                                                                style="{{ $data->field_type_1 == 'multiple' ? 'visibility: visible;' : 'visibility: hidden;' }}"></i>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @php $count++; @endphp
                                                                        @if ($count % 2 == 0 || $loop->last)
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="col-md-5 col-form-label required">
                                                                        Claim Status
                                                                    </label>
                                                                    <div class="col-md-6">
                                                                        {!! Form::Select(
                                                                            'claim_status',
                                                                            [
                                                                                '' => '--Select--',
                                                                                'CE_Inprocess' => 'Inprocess',
                                                                                'CE_Pending' => 'Pending',
                                                                                'CE_Completed' => 'Completed',
                                                                                'CE_Clarification' => 'Clarification',
                                                                                'CE_Hold' => 'Hold',
                                                                            ],
                                                                            null,
                                                                            [
                                                                                'class' => 'form-control ',
                                                                                'autocomplete' => 'none',
                                                                                'id' => 'claim_status',
                                                                                'style' => 'background-color: #fff !important;cursor:pointer',
                                                                            ],
                                                                        ) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" style="justify-content: space-between;">


                                                                <p class="timer_1" aria-haspopup="true" aria-expanded="false" data-toggle="modal"
                                                                    data-target="#exampleModalCustomScrollable">

                                                                    <span title="Total hours">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22"
                                                                            fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                                                            <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z" />
                                                                            <path
                                                                                d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3" />
                                                                        </svg>
                                                                    </span><span id="elapsedTime" class="timer_2"></span>
                                                                </p>

                                                                <button type="submit" class="btn1" id="project_assign_save">Submit</button>
                                                            </div>
                                                        </div> --}}
                                                    </div>

                                            </div>
                                        @endif
                                </div>
                                {{-- <div class="modal fade modal-first" id="myModal_view" tabindex="-1" role="dialog"
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
                                                    <div class="modal-header" style="background-color: #191C24;height: 84px">

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
                                                                <div class="bg-white rounded-pill px-2 text-black" style="margin-bottom: 2rem;margin-left:2.2px;font-size:10px;font-weight:500;background-color:#E9F3FF;color:#5D84FF;">
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
                                                                    <input type="hidden" name="{{ $columnName }}[]">

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
                                                                    $inputType = $data->input_type;
                                                                    $options =
                                                                        $data->options_name != null ? explode(',', $data->options_name) : null;
                                                                    $associativeOptions = [];
                                                                    if ($options !== null) {
                                                                        foreach ($options as $option) {
                                                                            $associativeOptions[$option] = $option;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if ($count % 2 == 0)
                                                                    <div class="row" id={{ $columnName }}>
                                                                @endif
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-md-12 {{ $data->field_type_2 == 'mandatory' ? 'required' : '' }}">
                                                                                {{ $labelName }}
                                                                            </label>
                                                                            <div class="col-md-10">
                                                                                @if ($options == null)
                                                                                    @if ($inputType != 'date_range')
                                                                                        {!! Form::$inputType($columnName . '[]', null, [
                                                                                            'class' => 'form-control ' . $columnName,
                                                                                            'autocomplete' => 'none',
                                                                                            'style' => 'cursor:pointer',
                                                                                            'rows' => 3,
                                                                                            'id' => $columnName,
                                                                                            $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                        ]) !!}
                                                                                    @else
                                                                                        {!! Form::text($columnName . '[]', null, [
                                                                                            'class' => 'form-control date_range daterange_' . $columnName,
                                                                                            'autocomplete' => 'none',
                                                                                            'style' => 'cursor:pointer',
                                                                                            'id' => 'date_range',
                                                                                            $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                        ]) !!}
                                                                                    @endif
                                                                                @else
                                                                                    @if ($inputType == 'select')
                                                                                        {!! Form::$inputType($columnName . '[]', ['' => '-- Select --'] + $associativeOptions, null, [
                                                                                            'class' => 'form-control ' . $columnName,
                                                                                            'autocomplete' => 'none',
                                                                                            'style' => 'cursor:pointer',
                                                                                            'id' => $columnName,
                                                                                            $data->field_type_2 == 'mandatory' ? 'required' : '',
                                                                                        ]) !!}
                                                                                    @elseif ($inputType == 'checkbox')
                                                                                        <p id="check_p1"
                                                                                            style="display:none;color:red; margin-left: 3px;">Checkbox
                                                                                            is mandatory</p>
                                                                                        <div class="form-group row">
                                                                                            @for ($i = 0; $i < count($options); $i++)
                                                                                                <div class="col-md-6">
                                                                                                    <div class="checkbox-inline mt-2">
                                                                                                        <label class="checkbox pop-non-edt-val"
                                                                                                            style="word-break: break-all;">
                                                                                                            {!! Form::$inputType($columnName . '[]', $options[$i], false, [
                                                                                                                'class' => $columnName,
                                                                                                                'id' => $columnName,
                                                                                                            ]) !!}{{ $options[$i] }}
                                                                                                            <span></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endfor
                                                                                        </div>
                                                                                    @elseif ($inputType == 'radio')
                                                                                        <p id="radio_p1"
                                                                                            style="display: none; color: red; margin-left: 3px;">Radio
                                                                                            is mandatory</p>
                                                                                        <div class="form-group row">
                                                                                            @for ($i = 0; $i < count($options); $i++)
                                                                                                <div class="col-md-6">
                                                                                                    <div class="radio-inline mt-2">
                                                                                                        <label class="radio pop-non-edt-val"
                                                                                                            style="word-break: break-all;">
                                                                                                            {!! Form::$inputType($columnName, $options[$i], false, [
                                                                                                                'class' => $columnName,
                                                                                                            ]) !!}{{ $options[$i] }}
                                                                                                            <span></span>
                                                                                                        </label>
                                                                                                    </div>

                                                                                                </div>
                                                                                            @endfor

                                                                                        </div>
                                                                                    @endif
                                                                                @endif

                                                                            </div>
                                                                            <div class="col-md-1 col-form-label pt-0 pb-4" style="margin-left: -1.3rem;">
                                                                                <input type="hidden"
                                                                                    value="{{ $associativeOptions != null ? json_encode($associativeOptions) : null }}"
                                                                                    class="add_options">

                                                                                @if ($data->field_type_1 == 'multiple')

                                                                                    <input type="hidden"
                                                                                        value="{{ $data->field_type_1 == 'multiple' ? $labelName : '' }}"
                                                                                        class="add_labelName">
                                                                                    <input type="hidden"
                                                                                        value="{{ $data->field_type_1 == 'multiple' ? $columnName : '' }}"
                                                                                        class="add_columnName">
                                                                                    <input type="hidden"
                                                                                        value="{{ $data->field_type_1 == 'multiple' ? $inputType : '' }}"
                                                                                        class="add_inputtype">
                                                                                    <input type="hidden"
                                                                                        value="{{ $data->field_type_1 == 'multiple' ? ($data->field_type_2 == 'mandatory' ? 'required' : '') : '' }}"
                                                                                        class="add_mandatory">

                                                                                @endif
                                                                            </div>
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
                                                                        <label class="col-md-12 required">
                                                                            Claim Status
                                                                        </label>
                                                                        <div class="col-md-10">
                                                                            {!! Form::Select(
                                                                                'claim_status',
                                                                                [
                                                                                    '' => '--Select--',
                                                                                    'CE_Inprocess' => 'Inprocess',
                                                                                    'CE_Pending' => 'Pending',
                                                                                    'CE_Completed' => 'Completed',
                                                                                    'CE_Clarification' => 'Clarification',
                                                                                    'CE_Hold' => 'Hold',
                                                                                ],
                                                                                null,
                                                                                [
                                                                                    'class' => 'form-control white-smoke  pop-non-edt-val ',
                                                                                    'autocomplete' => 'none',
                                                                                    'id' => 'claim_status',
                                                                                    'style' => 'cursor:pointer',
                                                                                ],
                                                                            ) !!}
                                                                        </div>
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
                                </div> --}}
                                <div class="modal fade modal-second" id="myModal_sop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">SOP</h5>
                                                <button type="button" class="close comment_close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src={{ asset('/pdf_folder/sample_1234.pdf') }} style="width: 100%; height: 500px;" frameborder="0" type="application/pdf"></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <a href={{ asset('/pdf_folder/sample_1234.pdf') }} target="_blank" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Tab</a>
                                                <button type="button" class="btn btn-light-danger" data-dismiss="modal">Close</button>
                                                <!-- Additional buttons can be added here -->
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
        max-width: 1000px;
        max-Height: 1200px;
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
    #myModal_view .modal-dialog {
        max-width: 1000px;
        max-Height: 1200px;
        /* Adjust the width as needed */
    }

    /* Style for labels */
    #myModal_view .modal-body label {
        margin-bottom: 5px;
    }

    /* Style for textboxes */
    #myModal_view .modal-body input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    /* .modal-first {
      left: 50%  !important;
      top: 50%  !important;
      transform: translate(-50%, -50%) !important;
    }
    .modal-second {
      position: absolute !important;
      left: calc(50% - 50px) !important;
      top: calc(50% - 50px) !important;
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
        var start = moment().startOf('month')
        var end = moment().endOf('month');
        $('.date_range').attr("autocomplete", "off");
        $('.date_range').daterangepicker({
            showOn: 'both',
            startDate: start,
            endDate: end,
            showDropdowns: true,
            ranges: {}
        });
        $('.date_range').val('');
        var startTime_db;
        $(document).ready(function() {

            var countDigits = {{ strlen($assignedCount) }};
            var newWidth = 30 + (countDigits - 1) * 6;
            var newHeight = 30 + (countDigits - 1) * 6;
            $('.code-badge-tab-selected').css({
                'width': newWidth + 'px',
                'height': newHeight + 'px'
            });
            $('.code-badge-tab').css({
                'width': newWidth + 'px',
                'height': newHeight + 'px'
            });


            var uniqueId = 0;
            $('.modal-body').on('click', '.add_more', function() {
                uniqueId++;

                var labelName = $(this).closest('.form-group').find('.add_labelName').val();
                var columnName = $(this).closest('.form-group').find('.add_columnName').val();
                var inputType = $(this).closest('.form-group').find('.add_inputtype').val();
                var addMandatory = $(this).closest('.form-group').find('.add_mandatory').val();
                var optionsJson = $(this).closest('.form-group').find('.add_options').val();
                var optionsObject = optionsJson ? JSON.parse(optionsJson) : null;
                var optionsArray = optionsObject ? Object.values(optionsObject) : null;

                var newElementId = 'dynamicElement_' + uniqueId;
                var newElement;
                if (optionsArray == null) {
                    if (inputType !== 'date_range') {
                        if (inputType == 'textarea') {
                            newElement = '<textarea name="' + columnName +
                                '[]"  class="form-control ' + columnName + ' white-smoke pop-non-edt-val" rows="3" id="' +
                                columnName +
                                uniqueId +
                                '"></textarea>';

                        } else {
                            newElement = '<input type="' + inputType + '" name="' + columnName +
                                '[]"  class="form-control ' + columnName + ' white-smoke pop-non-edt-val "  id="' +
                                columnName +
                                uniqueId +
                                '">';
                        }
                    } else {
                        newElement = '<input type="text" name="' + columnName +
                            '[]" class="form-control date_range "' + columnName +
                            ' pop-non-edt-val"  style="cursor:pointer" autocomplete="none" id="' +
                            columnName +
                            uniqueId +
                            '">';
                    }
                } else if (inputType === 'select') {

                    newElement = '<select name="' + columnName + '[]"  class="form-control ' +
                        columnName + ' white-smoke pop-non-edt-val" id="' +
                        columnName +
                        uniqueId +
                        '">';

                    optionsArray.unshift('-- Select --');
                    optionsArray.forEach(function(option) {
                        newElement += option != '-- Select --' ? '<option value="' + option + '">' +
                            option + '</option>' : '<option value="">' + option + '</option>';
                    });
                    newElement += '</select>';
                } else if (inputType === 'checkbox' && Array.isArray(optionsArray)) {
                    newElement = '<div class="form-group row">';

                    optionsArray.forEach(function(option) {
                        newElement +=
                            '<div class="col-md-6">' +
                            '<div class="checkbox-inline mt-2">' +
                            '<label class="checkbox pop-non-edt-val" style="word-break: break-all;" ' +
                            addMandatory + '>' +
                            '<input type="checkbox" name="' + columnName + '[]" value="' + option +
                            '" id="' +
                            columnName +
                            uniqueId +
                            '">' + option +
                            '<span></span>' +
                            '</label>' +
                            '</div>' +
                            '</div>';
                    });

                    newElement += '</div>';
                } else if (inputType === 'radio' && Array.isArray(optionsArray)) {
                    newElement = '<div class="form-group row">';
                    optionsArray.forEach(function(option) {
                        newElement +=
                            '<div class="col-md-6">' +
                            '<div class="radio-inline mt-2">' +
                            '<label class="radio pop-non-edt-val" style="word-break: break-all;" ' + addMandatory +
                            '>' +
                            '<input type="radio" name="' + columnName + '_' + uniqueId +
                            '" value="' + option + '" class="' + columnName + '" id="' +
                            columnName +
                            uniqueId +
                            '">' + option +
                            '<span></span>' +
                            '</label>' +
                            '</div>' +
                            '</div>';
                    });

                    newElement += '</div>';
                }

                var newRow = '<div class="row mt-2" id="' + newElementId + '">' +
                    '<div class="col-md-12">' +
                    '<label class="col-form-label ' + addMandatory + '">' +
                    labelName + '</label>' +
                    '</div>' +
                    '<div class="col-md-10">' + newElement + '</div>' +
                    '<div  class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                    '<i class="fa fa-minus minus_button remove_more" id="' + uniqueId +
                    '"></i>' +
                    '</div><div></div>' +
                    '</div>';
                var modalBody = $(this).closest('.modal-content').find('.modal-body');


                $(this).closest('.col-md-6').append(newRow);
                if (inputType === 'date_range') {
                    var newDateRangePicker = modalBody.find('#' + newElementId).find('.date_range');
                    newDateRangePicker.daterangepicker({
                        showOn: 'both',
                        startDate: start,
                        endDate: end,
                        showDropdowns: true,
                        ranges: {}
                    });
                    newDateRangePicker.val('');
                }
            });

            $(document).on('click', '.remove_more', function() {
                var uniqueId = $(this).attr('id');
                var elementId = 'dynamicElement_' + uniqueId;
                $('#' + elementId).remove();
            });

            var table = $("#client_assigned_list").DataTable({
                processing: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
                // scrollCollapse: true,
                // scrollX: true,
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
                $('#myModal_view').modal('show');
                var $row = $(this).closest('tr');
                var tdCount = $row.find('td').length;
                var thCount = tdCount - 1;

                var headers = [];
                $row.closest('table').find('thead th input').each(function() {
                    if ($(this).val() != undefined) {
                        headers.push($(this).val());
                    }
                });

                $row.find('td:not(:eq(' + thCount + '))').each(function(index) {
                    var header = headers[index];
                    var value = $(this).text().trim();
                    if (header == 'id') {
                        $('input[name="idValue"]').val(value);
                    }
                    if (header == 'claim_status') {
                        // $('select[name="claim_status"]').val(value).trigger('change');
                        $('select[name="claim_status"]').val('CE_Inprocess').trigger('change');
                        $('#title_status').text('In Process');
                    }
                    if ($('input[name="' + header + '[]"]').is(':checkbox')) {
                        var checkboxValues = value.split(',');
                        $('input[name="' + header + '[]"]').each(function() {
                            $(this).prop('checked', checkboxValues.includes($(this).val()));
                        });
                    } else if ($('input[name="' + header + '"]').is(':radio') && value !== '' &&
                        value.length > 0) {
                        $('input[name="' + header + '"]').filter('[value="' + value + '"]').prop(
                            'checked', true);
                    } else if ($('select[name="' + header + '[]"]').length) {
                        $('select[name="' + header + '[]"]').val(value).trigger('change');
                    } else {
                        $('textarea[name="' + header + '[]"]').val(value);
                        if (!isNaN(Date.parse(value))) {
                            var momentDate = moment(value, ['MM/DD/YYYY', 'YYYY-MM-DD'], true);
                            if (momentDate.isValid()) {
                                var formattedDate = new Date(value).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                });
                                customDate = moment(value, 'MM/DD/YYYY').format('YYYY-MM-DD');
                                $('label[id="' + header + '"]').text(formattedDate);
                                if ($('input[name="' + header + '[]"]').attr('type') === 'date') {
                                    $('input[name="' + header + '[]"]').val(customDate)
                                } else {
                                    $('input[name="' + header + '[]"]').val(value);
                                }
                                // var dateRangePicker = $('.date_range').data('daterangepicker');
                                // if (dateRangePicker) {
                                //     dateRangePicker.setStartDate(moment(customDate));
                                //     dateRangePicker.setEndDate(moment(customDate));
                                // }
                            } else {
                                $('input[name="' + header + '[]"]').val(value);
                                $('label[id="' + header + '"]').text(value);

                            }
                        } else {
                            $('input[name="' + header + '[]"]').val(value);
                            $('label[id="' + header + '"]').text(value);

                        }

                    }

                });
            });
            $(document).on('click', '.clickable-row', function(e) {
                var record_id = $(this).closest('tr').find('td:eq(0)').text();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });

                $.ajax({
                    url: "{{ url('caller_chart_work_logs') }}",
                    method: 'POST',
                    data: {
                        record_id: record_id,
                        clientName: clientName,
                        subProjectName: subProjectName
                    },
                    success: function(response) {
                        if (response.success == true) {
                             $('#myModal_status').modal('show');
                            startTime_db = response.startTimeVal;
                            console.log(startTime_db, 'startTime_db');
                        } else {
                            $('#myModal_status').modal('hide');
                            js_notification('error', 'Something went wrong');
                        }
                    },
                });

                // $('#myModal_status').modal('show');
                var $row = $(this).closest('tr');
                var tdCount = $row.find('td').length;
                var thCount = tdCount - 1;

                var headers = [];
                $row.closest('table').find('thead th input').each(function() {
                    if ($(this).val() != undefined) {
                        headers.push($(this).val());
                    }
                });

                $row.find('td:not(:eq(' + thCount + '))').each(function(index) {
                    var header = headers[index];
                    var value = $(this).text().trim();
                    if (header == 'id') {
                        $('input[name="idValue"]').val(value);
                    }
                    if (header == 'claim_status') {
                        // $('select[name="claim_status"]').val(value).trigger('change');
                        $('select[name="claim_status"]').val('CE_Inprocess').trigger('change');
                        $('#title_status').text('In Process');
                    }
                    if ($('input[name="' + header + '[]"]').is(':checkbox')) {
                        var checkboxValues = value.split(',');
                        $('input[name="' + header + '[]"]').each(function() {
                            $(this).prop('checked', checkboxValues.includes($(this).val()));
                        });
                    } else if ($('input[name="' + header + '"]').is(':radio') && value !== '' &&
                        value.length > 0) {
                        $('input[name="' + header + '"]').filter('[value="' + value + '"]').prop(
                            'checked', true);
                    } else if ($('select[name="' + header + '[]"]').length) {
                        $('select[name="' + header + '[]"]').val(value).trigger('change');
                    } else {
                        $('textarea[name="' + header + '[]"]').val(value);
                        if (!isNaN(Date.parse(value))) {
                            var momentDate = moment(value, ['MM/DD/YYYY', 'YYYY-MM-DD'], true);
                            if (momentDate.isValid()) {
                                var formattedDate = new Date(value).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                });
                                customDate = moment(value, 'MM/DD/YYYY').format('YYYY-MM-DD');
                                $('label[id="' + header + '"]').text(formattedDate);
                                if ($('input[name="' + header + '[]"]').attr('type') === 'date') {
                                    $('input[name="' + header + '[]"]').val(customDate)
                                } else {
                                    $('input[name="' + header + '[]"]').val(value);
                                }
                                // var dateRangePicker = $('.date_range').data('daterangepicker');
                                // if (dateRangePicker) {
                                //     dateRangePicker.setStartDate(moment(customDate));
                                //     dateRangePicker.setEndDate(moment(customDate));
                                // }
                            } else {
                                $('input[name="' + header + '[]"]').val(value);
                                $('label[id="' + header + '"]').text(value);

                            }
                        } else {
                            $('input[name="' + header + '[]"]').val(value);
                            $('label[id="' + header + '"]').text(value);

                        }

                    }

                });
            });
            $(document).on('click', '#sop_click', function(e) {
                console.log('sop modal');
                $('#myModal_sop').modal('show');
            });
            $(document).on('click', '#project_assign_save', function(e) {
                e.preventDefault();
                var fieldNames = $('#formConfiguration').serializeArray().map(function(input) {
                    return input.name;
                });
                var requiredFields = {};
                var requiredFieldsType = {};
                var inputclass = [];
                var inputTypeValue = 0;
                $('#formConfiguration').find(':input[required], select[required], textarea[required]',
                    ':input[type="checkbox"][required], input[type="radio"]').each(
                    function() {
                        var fieldName = $(this).attr('name');
                        var fieldType = $(this).attr('type') || $(this).prop('tagName').toLowerCase();

                        // Check if the field type already exists in the object
                        if (!requiredFields[fieldType]) {
                            requiredFields[fieldType] = [];
                        }

                        // Add the field name to the corresponding field type
                        requiredFields[fieldType].push(fieldName);
                    });

                //  $('input[type="checkbox"]:not(:checked), input[type="radio"]:not(:checked)').each(function () {
                //     var fieldName = $(this).attr("class");
                //     var fieldType = $(this).attr("type");

                //     if (fieldType === "checkbox") {//console.log('checkbox',fieldType,fieldName,$(this).attr("id"),$(this).val());
                //         $(this).parent().css("border-color", "red"); // Highlight the checkbox label or container
                //     } else if (fieldType === "radio") {//console.log('radio',fieldType,fieldName,$(this).attr("id"),$(this).val());
                //         // Highlight all radio buttons with the same name (group)
                //         $('input[type="radio"][name="' + fieldName + '"]').parent().css("border-color", "red");
                //     }
                // });

                $('input[type="radio"]').each(function() {
                    var groupName = $(this).attr("name");
                    // if ($('input[type="radio"][name="' + groupName + '"]:checked').length === 0) {
                    if ($('input[type="radio"][name="' + groupName + '"]:checked').length === 0) {
                        $('#radio_p1').css('display', 'block');
                        inputTypeValue = 1;
                    } else {
                        $('#radio_p1').css('display', 'none');
                        inputTypeValue = 0;
                    }
                    //     return false;
                    // }
                });


                $('input[type="checkbox"]').each(function() {
                    var groupName = $(this).attr("id");
                    console.log(groupName, 'chckkkkkkkk');
                    if ($('input[type="checkbox"][id="' + groupName + '"]:checked').length === 0) {
                        if ($('input[type="checkbox"][id="' + groupName + '"]:checked').length ===
                            0) {
                            $('#check_p1').css('display', 'block');
                            inputTypeValue = 1;
                        } else {
                            $('#check_p1').css('display', 'none');
                            inputTypeValue = 0;
                        }
                        return false;
                    }
                });

                for (var fieldType in requiredFields) {
                    if (requiredFields.hasOwnProperty(
                            fieldType)) { //console.log(requiredFields,'requiredFields');
                        var fieldNames = requiredFields[fieldType];
                        fieldNames.forEach(function(fieldNameVal) {
                            var label_id = $('' + fieldType + '[name="' + fieldNameVal + '"]').attr(
                                'class');
                            var classValue = (fieldType == 'text' || fieldType == 'date') ? $(
                                    'input' + '[name="' + fieldNameVal + '"]').attr(
                                    'class') : $('' + fieldType + '[name="' + fieldNameVal + '"]')
                                .attr(
                                    'class');
                            if (classValue !== undefined) {
                                var classes = classValue.split(' ');
                                inputclass.push($('.' + classes[1]));
                                inclass = $('.' + classes[1]);
                                // console.log(inclass,'inclass',inputclass[0]);
                                inclass.each(function(element) {

                                    var label_id = $(this).attr('id');
                                     console.log(label_id, 'label_id',$('#' + label_id).val(),$(this).val());
                                    if ($(this).val() == '') {
                                        if ($(this).val() == '') { //alert(label_id);
                                            e.preventDefault();
                                            $(this).css('border-color', 'red', 'important');
                                            inputTypeValue =
                                                1; // console.log('inside',inputTypeValue);
                                        } else {
                                            $(this).css('border-color', '');
                                            inputTypeValue =
                                                0; //console.log('else',inputTypeValue);
                                        }
                                        return false;
                                    }
                                });

                                // if ($('.' + classes[1]).val() == '') {
                                //     $('.' + classes[1]).css('border-color', 'red');
                                //     labelNameValue = 1;
                                //     return false; // This will exit the forEach loop, not the entire function
                                // } else {
                                //     $('.' + classes[1]).css('border-color', '');
                                //     labelNameValue = 0;
                                // }
                            }
                        });

                    }
                }

                var fieldValuesByFieldName = {};

                $('input[type="radio"]:checked').each(function() {
                    var fieldName = $(this).attr('class');
                    var fieldValue = $(this).val();
                    if (!fieldValuesByFieldName[fieldName]) {
                        fieldValuesByFieldName[fieldName] = [];
                    }

                    fieldValuesByFieldName[fieldName].push(fieldValue);
                });
                var groupedData = {};
                Object.keys(fieldValuesByFieldName).forEach(function(key) {
                    var columnName = key;
                    if (!groupedData[columnName]) {
                        groupedData[columnName] = [];
                    }
                    groupedData[columnName] = groupedData[columnName].concat(fieldValuesByFieldName[
                        key]);
                });
                $.each(fieldValuesByFieldName, function(fieldName, fieldValues) {
                    $.each(fieldValues, function(index, value) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: fieldName + '[]',
                            value: value
                        }).appendTo('form#formConfiguration');
                    });
                });



                if (inputTypeValue == 0) {

                    swal.fire({
                        text: "Do you want to update?",
                        icon: "success",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-white-black",
                            cancelButton: "btn font-weight-bold btn-light-danger",
                        }

                    }).then(function(result) {
                        if (result.value == true) {
                            document.querySelector('#formConfiguration').submit();

                        } else {
                            //   location.reload();
                        }
                    });

                } else {
                    return false;
                }
            });
            $("#ckbCheckAll").click(function() {
                var isChecked = $(this).prop('checked');
                $(".checkBoxClass").prop('checked', isChecked);

                // Iterate over all DataTable pages
                var table = $('#client_assigned_list').DataTable();
                for (var i = 0; i < table.page.info().pages; i++) {
                    table.page(i).draw(false); // Switch to page i
                    $(".checkBoxClass").prop('checked', isChecked); // Select checkboxes on the current page
                }
                if ($(this).prop('checked') == true && $('.checkBoxClass:checked').length > 0) {
                    $('#assigneeDropdown').prop('disabled', false);
                } else {
                    $('#assigneeDropdown').prop('disabled', true);

                }
            });

            //per page
            // $("#ckbCheckAll").click(function() {
            //     $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            //     console.log($(this).prop('checked'), $(".checkBoxClass").length, 'log');
            //     if ($(this).prop('checked') == true && $('.checkBoxClass:checked').length > 0) {
            //         $('#assigneeDropdown').prop('disabled', false);
            //     } else {
            //         $('#assigneeDropdown').prop('disabled', true);

            //     }
            // });
            $('.checkBoxClass').change(function() {
                var anyCheckboxChecked = $('.checkBoxClass:checked').length > 0;
                var allCheckboxesChecked = $('.checkBoxClass:checked').length === $('.checkBoxClass')
                    .length;
                if (allCheckboxesChecked) {
                    $("#ckbCheckAll").prop('checked', $(this).prop('checked'));
                } else {
                    $("#ckbCheckAll").prop('checked', false);
                }
                console.log(allCheckboxesChecked, 'allCheckboxesChecked', anyCheckboxChecked);
                $('#assigneeDropdown').prop('disabled', !(anyCheckboxChecked || allCheckboxesChecked));
            });


            $('#assigneeDropdown').change(function() {
                assigneeId = $(this).val();
                // checkedRowValues = $("input[name='check[]']").serializeArray();//per page

                var checkedRowValues = [];
                $('#client_assigned_list').DataTable().$('input[name="check[]"]:checked').each(function() {
                    var rowData = {
                        name: 'check[]',
                        value: $(this).val()
                    };
                    checkedRowValues.push(rowData);
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
                swal.fire({
                    text: "Do you want to change assignee?",
                    icon: "success",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-primary",
                        cancelButton: "btn font-weight-bold btn-danger",
                    }

                }).then(function(result) {
                    if (result.value == true) {
                        $.ajax({
                            url: "{{ url('assignee_change') }}",
                            method: 'POST',
                            data: {
                                assigneeId: assigneeId,
                                checkedRowValues: checkedRowValues,
                                clientName: clientName,
                                subProjectName: subProjectName
                            },
                            success: function(response) {
                                console.log(response, 'response', response.success);
                                if (response.success == true) {
                                    js_notification('success',
                                        'Assignee Updated Successfully');
                                } else {
                                    js_notification('error', 'Something went wrong');
                                }
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            },
                        });

                    } else {
                        location.reload();
                    }
                });
            })

            //tab redirect in below
            $(document).on('click', '.one', function() {
                window.location.href = "{{ url('#') }}";
            })

            $(document).on('click', '.two', function() {
                window.location.href = baseUrl + 'projects_pending/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.three', function() {
                window.location.href = baseUrl + 'projects_hold/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()["parent"] +
                    "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.four', function() {
                window.location.href = baseUrl + 'projects_completed/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.five', function() {
                window.location.href = baseUrl + 'projects_rework/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.six', function() {
                window.location.href = baseUrl + 'projects_duplicate/' + clientName + '/' + subProjectName +
                    "?parent=" +
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
        })

        function updateTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var startTime = new Date(startTime_db).getTime();

            // Current time clock
            // hours = (hours < 10 ? "0" : "") + hours;
            // minutes = (minutes < 10 ? "0" : "") + minutes;
            // seconds = (seconds < 10 ? "0" : "") + seconds;
            // document.getElementById("time").innerHTML = hours + ":" + minutes + ":" + seconds;

            // var elapsedTime = Math.floor((new Date().getTime() - startTime) / 1000 / 60);
            var elapsedTimeMs = new Date().getTime() - startTime;
            var elapsedHours = Math.floor(elapsedTimeMs / (1000 * 60 * 60));
            var remainingMinutes = Math.floor((elapsedTimeMs % (1000 * 60 * 60)) / (1000 * 60));
            elapsedHours = (elapsedHours < 10 ? "0" : "") + elapsedHours;
            remainingMinutes = (remainingMinutes < 10 ? "0" : "") + remainingMinutes;
            document.getElementById("elapsedTime").innerHTML = elapsedHours + " : " + remainingMinutes;
            setTimeout(updateTime, 1000);
        }
        updateTime();
    </script>
@endpush
