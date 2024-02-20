@extends('layouts.app3')
@include('productions.subheader')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid p-0">
                <div class="card card-custom card-transparent">
                    <div class="card-body p-0">
                        @php
                            $empDesignation = Session::get('loginDetails') && Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] != null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : '';
                            //$encodedId = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(Str::lower($databaseConnection));
                        @endphp
                        <div class="wizard wizard-4" id="kt_wizard_v4" data-wizard-state="step-first"
                            data-wizard-clickable="true">
                            <div class="wizard-nav">
                                <div class="wizard-steps">
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
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
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
                                {{-- <input type="hidden" value={{ $databaseConnection }} id="dbConnection"> --}}
                                {{-- <input type="hidden" value={{ $encodedId }} id="encodeddbConnection"> --}}
                                <input type="hidden" value={{ $clientName }} id="clientName">
                                <input type="hidden" value={{ $subProjectName }} id="subProjectName">

                                <div class="table-responsive pt-5">
                                    <table class="table table-separate table-head-custom no-footer dtr-column "
                                        id="client_assigned_list">
                                        <thead>

                                            <tr>
                                                @if ($assignedProjectDetails->contains('key', 'value'))
                                                    @foreach ($assignedProjectDetails[0]->getAttributes() as $columnName => $columnValue)
                                                        @php
                                                            $columnsToExclude = ['id', 'created_at', 'updated_at', 'deleted_at'];
                                                        @endphp
                                                        @if (!in_array($columnName, $columnsToExclude))
                                                            {{-- <th style="width:12%"><input type="hideen"
                                                                    value={{ $columnValue }}>{{ str_replace(['_', '_else_'], [' ', '/'], ucwords(str_replace('_', ' ', $columnValue))) }}
                                                            </th> --}}
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


                                        </thead>
                                        <tbody>
                                            @if (isset($assignedProjectDetails))
                                                @foreach ($assignedProjectDetails as $data)
                                                    <tr class="clickable-row"
                                                        style="{{ $data->invoke_date == 125 ? 'background-color: #f77a7a;' : '' }}">
                                                        @foreach ($data->getAttributes() as $columnName => $columnValue)
                                                            @php
                                                                $columnsToExclude = ['created_at', 'updated_at', 'deleted_at'];
                                                            @endphp
                                                            @if (!in_array($columnName, $columnsToExclude))
                                                                @if ($columnName != 'id')
                                                                    <td>
                                                                        @if (strtotime($columnValue))
                                                                            {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                        @else
                                                                            {{ $columnValue }}
                                                                        @endif
                                                                    </td>
                                                                @else
                                                                    <td style="display:none">
                                                                        @if (strtotime($columnValue))
                                                                            {{ date('m/d/Y', strtotime($columnValue)) }}
                                                                        @else
                                                                            {{ $columnValue }}
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                            @endif
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
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="modal fade" id="myModal_status" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
                                @if ($popUpHeader != null)
                                    <div class="modal-dialog">
                                        @php
                                            $clientName = App\Http\Helper\Admin\Helpers::projectName($popUpHeader->project_id);
                                            $practiceName = App\Http\Helper\Admin\Helpers::subProjectName($popUpHeader->project_id, $popUpHeader->sub_project_id);
                                            $projectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID($popUpHeader->project_id, 'encode');
                                            $subProjectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID($popUpHeader->project_id, 'encode');

                                        @endphp
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

                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title" id="myModalLabel">
                                                    {{ $clientName->project_name }}-{{ $practiceName->sub_project_name }}
                                                </h4>
                                                <a href="" style="margin-left: 40rem;">SOP</a>
                                                <button type="button" class="close comment_close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>

                                            </div>
                                            <div class="modal-body">
                                                @if (count($popupNonEditableFields) > 0)
                                                    @php $count = 0; @endphp
                                                    <input type="hidden" name="idValue">
                                                    @foreach ($popupNonEditableFields as $data)
                                                        @php
                                                            // $columnName = Str::lower(str_replace([' ', '/'], '_', $data->label_name));
                                                            $columnName = Str::lower(str_replace([' ', '/'], ['_', '_else_'], $data->label_name));
                                                            $inputType = $data->input_type;
                                                            $options = $data->options_name != null ? explode(',', $data->options_name) : null;
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
                                <hr>
                                @endif
                                @if (count($popupEditableFields) > 0)
                                    @php $count = 0; @endphp
                                    @foreach ($popupEditableFields as $key => $data)
                                        @php
                                            $labelName = $data->label_name;
                                            $columnName = Str::lower(str_replace([' ', '/'], ['_', '_else_'], $data->label_name));
                                            $inputType = $data->input_type;
                                            $options = $data->options_name != null ? explode(',', $data->options_name) : null;
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
                                                            <div class="form-group row">
                                                                @for ($i = 0; $i < count($options); $i++)
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox-inline mt-2">
                                                                            <label class="checkbox"
                                                                                style="word-break: break-all;">
                                                                                {!! Form::$inputType($columnName . '[]', $options[$i], false, [
                                                                                    'class' => $columnName,
                                                                                ]) !!}{{ $options[$i] }}
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        @elseif ($inputType == 'radio')
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
                                                        <i class="fa fa-plus text-success icon-circle1 ml-1 add_more"
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
                                        Status
                                    </label>
                                    <div class="col-md-6">
                                        {!! Form::Select('claim_status',  [
                                            '' => '--Select--',
                                            'CE_Assigned' => 'CE Assigned',
                                            'CE_Inprocess' => 'CE Inprocess',
                                            'CE_Pending' => 'CE Pending',
                                            'CE_Completed' => 'CE Completed',
                                            'CE_Clarification' => 'CE Clarification',
                                            'CE_Hold' => 'CE Hold',
                                        ], null, [
                                            'class' => 'form-control ',
                                            'autocomplete' => 'none',
                                            'id' => 'claim_status',
                                            'style' => 'background-color: #fff !important;cursor:pointer',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default comment_close"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="project_assign_save">Submit</button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                    @endif
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
        $(document).ready(function() {
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
                // console.log(labelName, columnName, inputType, addMandatory, 'inputType');

                var newElementId = 'dynamicElement_' + uniqueId;
                var newElement;
                if (optionsArray == null) {
                    if (inputType !== 'date_range') {
                        if (inputType == 'textarea') {
                            newElement = '<textarea name="' + columnName +
                                '[]"  class="text-black form-control ' + columnName + '" rows="3" id="' +
                                columnName +
                                uniqueId +
                                '"></textarea>';

                        } else {
                            newElement = '<input type="' + inputType + '" name="' + columnName +
                                '[]"  class="text-black form-control ' + columnName + '" >';
                        }
                    } else {
                        newElement = '<input type="text" name="' + columnName +
                            '[]" class="form-control date_range "' + columnName +
                            '  style="background-color: #fff !important;cursor:pointer" autocomplete="none">';
                    }
                } else if (inputType === 'select') {

                    newElement = '<select name="' + columnName + '[]"  class="text-black form-control ' +
                        columnName + '" >';

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
                            '<label class="checkbox" style="word-break: break-all;" ' +
                            addMandatory + '>' +
                            '<input type="checkbox" name="' + columnName + '[]" value="' + option +
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
                            '<label class="radio" style="word-break: break-all;" ' + addMandatory +
                            '>' +
                            '<input type="radio" name="' + columnName + '_' + uniqueId +
                            '" value="' + option + '" class="' + columnName + '">' + option +
                            '<span></span>' +
                            '</label>' +
                            '</div>' +
                            '</div>';
                    });

                    newElement += '</div>';
                }

                var newRow = '<div class="row mt-2" id="' + newElementId + '">' +
                    '<div class="col-md-5">' +
                    '<label class="col-form-label ' + addMandatory + '">' +
                    labelName + '</label>' +
                    '</div>' +
                    '<div class="col-md-6">' + newElement + '</div>' +
                    '<div  class="col-form-label text-lg-right pt-0 pb-4">' +
                    '<i class="fa fas fa-minus text-danger icon-circle1 ml-1 remove_more" id="' + uniqueId +
                    '"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                var modalBody = $(this).closest('.modal-content').find('.modal-body');


                $(this).closest('.form-group').after(newRow);
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
                //serverSide: true,
                lengthChange: false,
                searching: true,
                pageLength: 20,
                scrollCollapse: true,
                scrollX: true,
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
                    if (header == 'claim_status') {console.log(value,'val');
                        $('select[name="claim_status"]').val(value).trigger('change');
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
                                $('input[name="' + header + '[]"]').val(customDate);
                                var dateRangePicker = $('.date_range').data('daterangepicker');
                                if (dateRangePicker) {
                                    dateRangePicker.setStartDate(moment(customDate));
                                    dateRangePicker.setEndDate(moment(customDate));
                                }
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

            $(document).on('click', '#project_assign_save', function(e) {
                e.preventDefault();

                // var fieldTypes = $('input[type^="radio"]:checked').map(function() {

                //     return $(this).val();
                // }).get();
                // var fieldNames = $('input[type="radio"]:checked').map(function() {
                //     return $(this).attr('name');
                // }).get();
                // console.log('fieldTypes',fieldTypes,fieldTypes.length,fieldNames);
                //     for (var i = 0; i < fieldTypes.length; i++) {
                //         $('<input>').attr({
                //             type: 'hidden',
                //             name: fieldNames[0]+'[]',
                //             value: fieldTypes[i]
                //         }).appendTo('form#formConfiguration');

                //     }
                var fieldNames = $('#formConfiguration').serializeArray().map(function(input) {
                    return input.name;
                });
                // var requiredFields = [];
                // var requiredFieldsType = [];
                // // $('#formConfiguration').find(':input[required]').each(function() {
                //     requiredFields.push($(this).attr('name'));
                //     requiredFieldsType.push($(this).attr('type'));
                // });

                // $('#formConfiguration').find(':input[required], select[required], textarea[required]').each(
                //     function() {
                //         requiredFields.push($(this).attr('name'));
                //         requiredFieldsType.push($(this).attr('type') || $(this).prop('tagName')
                //             .toLowerCase());
                //     });

                // $('input[type="checkbox"][required], input[type="radio"][required]').each(function() {
                //     if ($(this).prop('checked')) {
                //         requiredFields.push($(this).attr('name'));
                //         requiredFieldsType.push($(this).attr('type'));
                //     }
                // });
                var requiredFields = {};
                var requiredFieldsType = {};
                var inputclass = [];
                // Iterate over input, select, and textarea elements with the required attribute
                $('#formConfiguration').find(':input[required], select[required], textarea[required]').each(
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

                // Iterate over checkboxes and radios with the required attribute
                $('input[type="checkbox"][required], input[type="radio"][required]').each(function() {
                    if ($(this).prop('checked')) {
                        var fieldName = $(this).attr('name');
                        var fieldType = $(this).attr('type');

                        // Check if the field type already exists in the object
                        if (!requiredFields[fieldType]) {
                            requiredFields[fieldType] = [];
                        }

                        // Add the field name to the corresponding field type
                        requiredFields[fieldType].push(fieldName);
                    }
                });

               // console.log(fieldNames, 'fieldNames', requiredFields, requiredFieldsType);
                // requiredFields.forEach(function(fieldName) {
                //     var fieldValue = $('#' + fieldName).val();console.log(fieldName,'fieldName');
                //     if (fieldValue === '') {
                //         $('#' + fieldName).css('border-color', 'red');
                //         labelNameValue = 1;
                //     } else {
                //         $('#' + fieldName).css('border-color', '');
                //         labelNameValue = 0;
                //     }
                // });
                // requiredFields.forEach(function() {
                //     var fieldName = 'coder_comment[]'; // Example field name
                //     var label_id = $('textarea[name="' + fieldName + '"]').attr('id');
                //     console.log($('#coder_comment').val(), $('#coder_comment1').val(), label_id,
                //         'label_id');

                //     if ($('#coder_comment1').val() == '') {
                //         $('#coder_comment1').css('border-color', 'red');
                //         labelNameValue = 1;
                //         return false;
                //     } else {
                //         $('#coder_comment1').css('border-color', '');
                //         labelNameValue = 0;
                //     }
                //     if ($('#coder_comment').val() == '') {
                //         $('#coder_comment').css('border-color', 'red');
                //         labelNameValue = 1;
                //         return false;
                //     } else {
                //         $('#coder_comment').css('border-color', '');
                //         labelNameValue = 0;
                //     }
                // });

                for (var fieldType in requiredFields) {
                    if (requiredFields.hasOwnProperty(fieldType)) {
                        var fieldNames = requiredFields[fieldType];
                        fieldNames.forEach(function(fieldName) {
                            var label_id = $('' + fieldType + '[name="' + fieldName + '"]').attr(
                                'class');
                            var classValue = $('' + fieldType + '[name="' + fieldName + '"]').attr(
                                'class');
                            if (classValue !== undefined) {
                                var classes = classValue.split(' ');
                                // Rest of your code using the classes array


                                console.log(classValue, 'classValue', classes[
                                    1]);
                                inputclass.push($('.' + classes[1]));

                                inclass = $('.' + classes[1]);
                                console.log(inputclass, 'inputClass', inclass,'testt',inclass[0]);
                                // inclass[1].each(function() {
                                //     console.log('inclass');
                                //     var label_id = $(this).attr('id');
                                //     console.log(label_id, 'label_id');
                                //     if ($('#' + label_id).val() == '') {
                                //         $('#' + label_id).css('border-color', 'red');
                                //         labelNameValue = 1;
                                //         return false;
                                //     } else {
                                //         $('#' + label_id).css('border-color', '');
                                //         labelNameValue = 0;
                                //     }
                                // });

                                if ($('.' + classes[1]).val() == '') {
                                    $('.' + classes[1]).css('border-color', 'red');
                                    labelNameValue = 1;
                                    return false; // This will exit the forEach loop, not the entire function
                                } else {
                                    $('.' + classes[1]).css('border-color', '');
                                    labelNameValue = 0;
                                }
                            }
                        });

                    }
                }

                var fieldValuesByFieldName = {};

                $('input[type="radio"]:checked').each(function() {
                    var fieldName = $(this).attr('class');
                    var fieldValue = $(this).val();
                    //console.log(fieldName, 'fieldName');
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
                //console.log(groupedData, 'fieldValuesByFieldName', fieldValuesByFieldName);
                $.each(fieldValuesByFieldName, function(fieldName, fieldValues) {
                    $.each(fieldValues, function(index, value) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: fieldName + '[]',
                            value: value
                        }).appendTo('form#formConfiguration');
                    });
                });

                var inputTypeValue = 0;

                if (inputTypeValue == 0) {

                    swal.fire({
                        text: "Do you want to update?",
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
                            document.querySelector('#formConfiguration').submit();

                        } else {
                            location.reload();
                        }
                    });

                } else {
                    return false;
                }
            });
            var clientName = $('#clientName').val();
            var subProjectName = $('#subProjectName').val();

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
    </script>
@endpush
