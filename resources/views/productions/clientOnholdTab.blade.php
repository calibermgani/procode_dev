@extends('layouts.app3')
@section('content')

                <div class="card card-custom custom-card">
                    <div class="card-body p-0">
                        @php
                             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail']['user_hrdetails'] &&  Session::get('loginDetails')['userDetail']['user_hrdetails']['current_designation']  !=null ? Session::get('loginDetails')['userDetail']['user_hrdetails']['current_designation']: "";
                             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
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
                                       <div class="outside float-right" href="javascript:void(0);"></div>
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
                                    <div class="wizard-step mb-0 three" data-wizard-type="step">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Hold</h6>
                                                    {{-- <div class="rounded-circle code-badge-tab-selected">
                                                        {{ $holdCount }}
                                                    </div> --}}
                                                    @include('CountVar.countRectangle', ['count' => $holdCount])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="wizard-step mb-0 four" data-wizard-type="done">
                                        <div class="wizard-wrapper py-2">
                                            <div class="wizard-label p-2 mt-2">
                                                <div class="wizard-title" style="display: flex; align-items: center;">
                                                    <h6 style="margin-right: 5px;">Completed</h6>
                                                    <div class="rounded-circle code-badge-tab">
                                                        {{ $completedCount }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
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
                                        id="client_onhold_list">
                                        <thead>
                                            @if (!empty($columnsHeader))
                                                <tr>
                                                    <th>Action</th>
                                                    @foreach ($columnsHeader as $columnName => $columnValue)
                                                        @if ($columnValue != 'id')
                                                            <th><input type="hidden"
                                                                    value={{ $columnValue }}>
                                                                {{ ucwords(str_replace(['_else_', '_'], ['/', ' '], $columnValue)) }}
                                                            </th>
                                                        @else
                                                            <th style="display:none"><input type="hidden"
                                                                    value={{ $columnValue }}>
                                                                {{ ucwords(str_replace(['_else_', '_'], ['/', ' '], $columnValue)) }}
                                                            </th>
                                                        @endif
                                                    @endforeach

                                                </tr>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @if (isset($holdProjectDetails))
                                                @foreach ($holdProjectDetails as $data)
                                                    <tr
                                                        style="{{ $data->invoke_date == 125 ? 'background-color: #f77a7a;' : '' }}">
                                                        <td>
                                                            @if (($empDesignation !== "Administrator" || strpos($empDesignation, 'Manager') !== true || strpos($empDesignation, 'VP') !== true || strpos($empDesignation, 'Leader') !== true || strpos($empDesignation, 'Team Lead') !== true || strpos($empDesignation, 'CEO') !== true || strpos($empDesignation, 'Vice') !== true) && $loginEmpId != $data->CE_emp_id)
                                                            {{-- @if (empty($assignedDropDown)) --}}
                                                            @else
                                                                @if (empty($existingCallerChartsWorkLogs))
                                                                    <button class="task-start clickable-row start"
                                                                        title="Start"><i class="fa fa-play-circle icon-circle1 mt-0" aria-hidden="true" style="color:#ffffff"></i></button>
                                                                @elseif(in_array($data->id, $existingCallerChartsWorkLogs))
                                                                    <button class="task-start clickable-row start"
                                                                        title="Start"><i class="fa fa-play-circle icon-circle1 mt-0" aria-hidden="true" style="color:#ffffff"></i></button>
                                                                @endif
                                                            @endif
                                                                    <button class="task-start clickable-view"
                                                                    title="View"><i
                                                                    class="fa far fa-eye text-eye icon-circle1 mt-0"></i></button>
                                                        </td>
                                                        @foreach ($data->getAttributes() as $columnName => $columnValue)
                                                            @php
                                                                $columnsToExclude = ['QA_emp_id','created_at', 'updated_at', 'deleted_at'];
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

                    <div class="modal fade modal-first" id="myModal_status" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
                     @if ($popUpHeader != null)
                         <div class="modal-dialog">
                             @php
                                 $clientName = App\Http\Helper\Admin\Helpers::projectName(
                                     $popUpHeader->project_id,
                                 );
                                 $projectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                     $popUpHeader->project_id,
                                     'encode',
                                 );
                                 if($popUpHeader->sub_project_id != NULL) {
                                        $practiceName = App\Http\Helper\Admin\Helpers::subProjectName(
                                            $popUpHeader->project_id,
                                            $popUpHeader->sub_project_id,
                                        );
                                        $subProjectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                        $popUpHeader->sub_project_id,
                                        'encode',
                                        );
                                    } else {
                                        $practiceName = '';
                                        $subProjectName = '--';
                                    }
                             @endphp


                                 <div class="modal-content" style="margin-top: 7rem">
                                     <div class="modal-header" style="background-color: #139AB3;height: 84px">
                                        <div class="row" style="height: auto;width:100%">
                                                <div class="col-md-4">
                                                    <div class="align-items-center" style="display: -webkit-box !important;">
                                                        <div class="rounded-circle bg-white text-black mr-2" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;font-weight;bold">
                                                            <span>{{ strtoupper(substr($clientName->project_name, 0, 1)) }}</span>
                                                        </div>&nbsp;&nbsp;
                                                        <div>
                                                            <h6 class="modal-title mb-0" id="myModalLabel" style="color: #ffffff;">
                                                                {{ ucfirst($clientName->project_name) }}
                                                            </h6>
                                                            @if($practiceName != '')
                                                            <h6 style="color: #ffffff;font-size:1rem;">{{ ucfirst($practiceName->sub_project_name) }}</h6>
                                                        @endif
                                                        </div>&nbsp;&nbsp;
                                                        <div class="bg-white rounded-pill px-2 text-black" style="margin-bottom: 2rem;margin-left:2.2px;font-size:10px;font-weight:500;background-color:#E9F3FF;color:#139AB3;">
                                                            <span id="title_status"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="col-md-8 justify-content-end" style="display: -webkit-box !important;">
                                                {{-- <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Reference</a>
                                                <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">MOM</a> --}}
                                                <button type="button" class="btn btn-black-white mr-3" id="sop_click" style="padding: 0.35rem 1rem;">SOP</button>
                                                {{-- <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Custom</a> --}}
                                            </div>
                                        </div>
                                     </div>
                                     {!! Form::open([
                                         'url' =>
                                             url('project_update/' . $projectName . '/' . $subProjectName) .
                                             '?parent=' .
                                             request()->parent .
                                             '&child=' .
                                             request()->child,
                                         'class' => 'form',
                                         'id' => 'holdFormConfiguration',
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
                                                     <input type="hidden" name="parentId">
                                                     <input type="hidden" name="record_old_status">
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
                                                     <div class="row">
                                                 @endif
                                                     <div class="col-md-6 dynamic-field">
                                                         <div class="form-group row row_mar_bm">
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
                                                                             'class' => 'form-control date_range ' . $columnName . ' white-smoke pop-non-edt-val',
                                                                             'autocomplete' => 'none',
                                                                             'style' => 'cursor:pointer',
                                                                             'id' => $columnName,
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
                                                                                                 'id' => $columnName,
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
                                                     <input type="hidden" name="invoke_date">
                                                     <input type="hidden" name="CE_emp_id">
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
                                                                    //  'CE_Clarification' => 'Clarification',
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

                                             <button type="submit" class="btn1" id="project_hold_save" style="margin-right: -2rem">Submit</button>
                                         </div>
                                     </div>
                                     {!! Form::close() !!}
                                 </div>

                         </div>
                     @endif
                </div>

                    <div class="modal fade modal-first" id="myModal_view" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
                        @if ($popUpHeader != null)
                            <div class="modal-dialog">
                                @php
                                    $clientName = App\Http\Helper\Admin\Helpers::projectName(
                                        $popUpHeader->project_id,
                                    );
                                    $projectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                        $popUpHeader->project_id,
                                        'encode',
                                    );
                                    if($popUpHeader->sub_project_id != NULL) {
                                        $practiceName = App\Http\Helper\Admin\Helpers::subProjectName(
                                            $popUpHeader->project_id,
                                            $popUpHeader->sub_project_id,
                                        );
                                        $subProjectName = App\Http\Helper\Admin\Helpers::encodeAndDecodeID(
                                        $popUpHeader->sub_project_id,
                                        'encode',
                                        );
                                    } else {
                                        $practiceName = '';
                                        $subProjectName = '';
                                    }
                                @endphp


                                    <div class="modal-content" style="margin-top: 7rem">
                                        <div class="modal-header" style="background-color: #139AB3;height: 84px">
                                            <div class="row" style="height: auto;width:100%">
                                                <div class="col-md-4">
                                                    <div class="align-items-center" style="display: -webkit-box !important;">
                                                        <!-- Round background for the first letter of the project name -->
                                                        <div class="rounded-circle bg-white text-black mr-2" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;font-weight;bold">
                                                            <span>{{ strtoupper(substr($clientName->project_name, 0, 1)) }}</span>
                                                        </div>&nbsp;&nbsp;
                                                        <div>
                                                            <!-- Project name -->
                                                            <h6 class="modal-title mb-0" id="myModalLabel" style="color: #ffffff;">
                                                                {{ ucfirst($clientName->project_name) }}
                                                            </h6>
                                                            @if($practiceName != '')
                                                            <h6 style="color: #ffffff;font-size:1rem;">{{ ucfirst($practiceName->sub_project_name) }}</h6>
                                                            @endif
                                                        </div>&nbsp;&nbsp;
                                                        <!-- Oval background for project status -->
                                                        <div class="bg-white rounded-pill px-2 text-black" style="margin-bottom: 2rem;margin-left:2.2px;font-size:10px;font-weight:500;background-color:#E9F3FF;color:#139AB3;">
                                                            <span id="title_status"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 justify-content-end" style="display: -webkit-box !important;">
                                                    {{-- <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Reference</a>
                                                    <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">MOM</a> --}}
                                                    <button type="button" class="btn btn-black-white mr-3" id="sop_click" style="padding: 0.35rem 1rem;">SOP</button>
                                                    {{-- <a href="" class="btn btn-black-white mr-3" style="padding: 0.35rem 1rem;">Custom</a> --}}
                                                </div>
                                            </div>
                                            {{-- <button type="button" class="close comment_close" data-dismiss="modal"
                                                aria-hidden="true" style="color:#ffffff !important">&times;</button> --}}

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
            function getUrlParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get the URL parameter dynamically
            const url = window.location.href;
            const startIndex = url.indexOf('projects_') + 'projects_'.length;
            const endIndex = url.indexOf('/', startIndex);
            const urlDynamicValue = url.substring(startIndex, endIndex);

            var uniqueId = 0;
            $('.modal-body').on('click', '.add_more', function() {
                var ids = [];
                clumnClassName = $(this).attr('id').replace(/^add_more_/, '');
                $('.' + clumnClassName).each(function() {
                    ids.push($(this).attr('id'));
                });
                var lastElement = ids[ids.length - 1];console.log(ids,'$(this)',clumnClassName,lastElement);
                var lastId = lastElement.replace(new RegExp('^' + clumnClassName), '');
                if (lastId) {
                    uniqueId=lastId;
                }
                uniqueId++;
               // console.log(lastId, lastElement,ids,clumnClassName,'clumnClassName',$(this).closest('.form-group').find('.add_labelName').val(),$('.'+clumnClassName).closest('.row_mar_bm').find('.add_labelName').val());
                var labelName =$('.'+clumnClassName).closest('.row_mar_bm').find('.add_labelName').val();
                var columnName = $('.'+clumnClassName).closest('.row_mar_bm').find('.add_columnName').val();
                var inputType = $('.'+clumnClassName).closest('.row_mar_bm').find('.add_inputtype').val();
                var addMandatory = $('.'+clumnClassName).closest('.row_mar_bm').find('.add_mandatory').val();
                var optionsJson = $('.'+clumnClassName).closest('.row_mar_bm').find('.add_options').val();
                var optionsObject = optionsJson ? JSON.parse(optionsJson) : null;
                var optionsArray = optionsObject ? Object.values(optionsObject) : null;

                var newElementId = 'dynamicElement_' + clumnClassName + uniqueId;
                var newElement;
                if (optionsArray == null) {
                    if (inputType !== 'date_range') {
                        if (inputType == 'textarea') {
                            newElement = '<textarea name="' + columnName +
                                '[]"  class="form-control ' + columnName + ' white-smoke pop-non-edt-val mt-0" rows="3" id="' +
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
                            '[]" class="form-control date_range ' + columnName +
                            ' white-smoke pop-non-edt-val"  style="cursor:pointer" autocomplete="none" id="' +
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
                            '" class="' +
                            columnName +
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
                            '" class="' +
                            columnName +
                            '">' + option +
                            '<span></span>' +
                            '</label>' +
                            '</div>' +
                            '</div>';
                    });

                    newElement += '</div>';
                }

                var plusButton = '<i class="fa fa-plus add_more" id="' +'add_more_'+columnName +'"></i>';
                // var minusButton = '<i class="fa fa-minus minus_button remove_more" id="' + uniqueId +'"></i>';
                var newRow = '<div class="row mt-6" id="' + newElementId + '">' +
                    '<div class="col-md-10">' + newElement + '</div>' +
                    '<div  class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                        plusButton +
                    '</div><div></div>' +
                    '</div>';
                var modalBody = $('.'+clumnClassName).closest('.modal-content').find('.modal-body');


                $(this).closest('.col-md-6').append(newRow);
                     elementToRemove = 'add_more_'+clumnClassName;
                                $('#'+elementToRemove).remove();
                                uniqueId = uniqueId-1;
                                removeId = uniqueId == 0 ? clumnClassName : clumnClassName+ uniqueId;console.log(removeId,'removeId');
                                //   $('#patient_name2').closest('.row_mar_bm').find('.col-md-1').append('<i class="fa fa-minus minus_button remove_more" id="' + uniqueId + '"></i>');
                                if(uniqueId > 0) {
                                  $('#'+lastElement).closest('.col-md-10').next('.col-md-1').append('<i class="fa fa-minus minus_button remove_more" id="'+removeId +'"></i>');
                                }


                if (inputType === 'date_range') {
                    var newDateRangePicker = modalBody.find('#' + newElementId).find('.date_range');
                    newDateRangePicker.daterangepicker({
                        showOn: 'both',
                        startDate: start,
                        endDate: end,
                        showDropdowns: true,
                        ranges: {}
                    }).attr("autocomplete", "off");
                    newDateRangePicker.val('');
                }
            });
            $(document).on('click', '.remove_more', function() {
                var uniqueId = $(this).attr('id');
                var elementId = 'dynamicElement_' + uniqueId;
                $('#' + elementId).remove();
            });
            var table = $("#client_onhold_list").DataTable({
                processing: true,
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

            $(document).on('click', '.clickable-row', function(e) {
                var classes = $(this).attr('class');
                var lastClass = '';
                if (classes) {
                    var classArray = classes.split(' ');
                    var lastClass = classArray[classArray.length - 1];
                }
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
                            subProjectName: subProjectName,
                            urlDynamicValue: urlDynamicValue
                        },
                        success: function(response) {
                            if(lastClass == 'start'){
                                if (response.success == true) {console.log(response.success,'success');
                                    $('#myModal_status').modal('show');
                                    startTime_db = response.startTimeVal;
                                    handleClientPendData(response.clientData,headers);
                                } else {
                                    $('#myModal_status').modal('hide');
                                    js_notification('error', 'Something went wrong');
                                }
                            }
                        },
                    });
                    function handleClientPendData(clientData,headers) {

                        $.each(headers, function(index, header) {
                            value = clientData[header];
                            $('label[id="' + header + '"]').html("");
                            $('input[name="' + header + '[]"]').html("");
                            if (/_el_/.test(value)) {
                                elementToRemove = 'add_more_'+header;
                                $('#'+elementToRemove).remove();
                             //   console.log( $('.'+header).closest('.row_mar_bm').find('.col-md-1'),'col',header);
                                // $('.' + header).closest('.row_mar_bm').find('.col-md-1').append('<i class="fa fa-minus minus_button remove_more" id="' + header + '"></i>');//initital row minus button

                                var values = value.split('_el_');
                                var optionsJson =  $('.'+header).closest('.dynamic-field').find('.add_options').val();
                                var optionsObject = optionsJson ? JSON.parse(optionsJson) : null;
                                var optionsArray = optionsObject ? Object.values(optionsObject) : null;
                                var inputType;
                                $('select[name="' + header + '[]"]').val(values[0]).trigger('change');
                                // $('input[name="' + header + '[]"]').val(values[0]);
                                $('textarea[name="' + header + '[]"]').val(values[0]);//console.log($('.'+header).attr('type'),'valuesType');
                                if ($('input[name="' + header + '[]"][type="checkbox"]').length > 0) {
                                    var checkboxValues = values[0].split(','); // Split the string into an array of checkbox values
                                    $('input[name="' + header + '[]"]').each(function() {
                                        var checkboxValue = $(this).val(); //console.log(checkboxValue,checkboxValues,'checkboxValues');
                                        var isChecked = checkboxValues.includes(checkboxValue);
                                        $(this).prop('checked', isChecked);
                                    });
                                }else if($('input[name="' + header + '"][type="radio"]').length > 0) {

                                    $('input[name="' + header + '"]').filter('[value="' + values[0] + '"]').prop(
                                        'checked', true);
                                } else {
                                    $('input[name="' + header + '[]"]').val(values[0]);
                                }


                                    for (var i = 1; i < values.length; i++) {
                                        var selectType;//console.log(values,'values',values[i],i,values.length);
                                        var isLastValue = i === values.length - 1;
                                        var newElementId =  'dynamicElement_' + header + i;//console.log($('textarea[name="' + header + '[]"]').prop('nodeName'),'textarea');
                                        if ($('select[name="' + header + '[]"]').prop('tagName') != undefined) {
                                                // Create a new <select> element
                                                selectType = $('<select>', {
                                                    name: header + '[]',
                                                    class: 'form-control ' + header + ' white-smoke pop-non-edt-val',
                                                    id: header + i
                                                });

                                                // Add an empty default option
                                                selectType.append($('<option>', { value: '', text: '-- Select --' }));

                                                // Add options from optionsArray
                                                optionsArray.forEach(function(option) {
                                                    selectType.append($('<option>', {
                                                        value: option,
                                                        text: option,
                                                        selected: option == values[i]  // Set selected attribute if option matches value
                                                    }));
                                                });

                                                // Append the select element to its parent
                                                var selectWrapper = $('<div>', { class: 'col-md-10' }).append(selectType);
                                                    if(i === values.length - 1) {//console.log(i,values.length - 1,'length');
                                                      var minusButton = $('<i>', { class: 'fa fa-plus add_more', id: 'add_more_'+header });
                                                } else {
                                                    var minusButton = $('<i>', { class: 'fa fa-minus minus_button remove_more', id: header+ i });
                                                }
                                                var colLabel = $('<div>', { class: 'col-md-1 col-form-label text-lg-right pt-0 pb-4', style: 'margin-left: -1.3rem;' }).append(minusButton);
                                                var rowDiv = $('<div>', { class: 'row mt-4', id: newElementId}).append(selectWrapper, colLabel);
                                                $('select[name="' + header + '[]"]').closest('.dynamic-field').append(rowDiv);

                                            } else if ($('textarea[name="' + header + '[]"]').prop('nodeName') != undefined) {
                                                    inputType =  '<textarea name="' + header + '[]" class="form-control ' + header + ' white-smoke pop-non-edt-val mt-0" rows="3" id="' + header + i + '">' + values[i] + '</textarea>';
                                                    if(i === values.length - 1) {//console.log(i,values.length - 1,'length');
                                                         var minusButton = '<i class="fa fa-plus add_more" id="' +'add_more_'+header +'"></i>';
                                                } else {
                                                    var minusButton = '<i class="fa fa-minus minus_button remove_more" id="'+header+ i +'"></i>';
                                                }
                                                    var span = '<div class="row mt-4" id="' + newElementId + '">' +
                                                        '<div class="col-md-10">' + inputType + '</div><div class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                                                            minusButton +'</div><div></div></div>';
                                                    $('textarea[name="' + header + '[]"]').closest('.dynamic-field').append(span);
                                                } else if ($('input[name="' + header + '[]"][type="checkbox"]').length > 0 && Array.isArray(optionsArray)) {
                                                        inputType = '<div class="form-group row">';
                                                        optionsArray.forEach(function(option) {
                                                            var checked = (values[i] && values[i].split(',').includes(option.toString())) ? 'checked' : '';
                                                            inputType +=
                                                                '<div class="col-md-6">' +
                                                                '<div class="checkbox-inline mt-2">' +
                                                                '<label class="checkbox pop-non-edt-val" style="word-break: break-all;" >' +
                                                                '<input type="checkbox" name="' + header + '[]" value="' + option + '" class="'+header +'" id="' +header + i + '" ' + checked + '>' + option +
                                                                '<span></span>' +
                                                                '</label>' +
                                                                '</div>' +
                                                                '</div>';
                                                        });

                                                        inputType += '</div>';
                                                        if(i === values.length - 1) {//console.log(i,values.length - 1,'length');
                                                         var minusButton = '<i class="fa fa-plus add_more" id="' +'add_more_'+header +'"></i>';
                                                        } else {
                                                            var minusButton = '<i class="fa fa-minus minus_button remove_more" id="'+header+ i +'"></i>';
                                                        }
                                                        var span = '<div class="row mt-4" id="' + newElementId + '">' +
                                                            '<div class="col-md-10">' + inputType + '</div><div  class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                                                                minusButton + '</div><div></div></div>';
                                                      //  console.log(header, 'header', $('.' + header).find('.col-md-6'));
                                                        $('input[name="' + header + '[]"]').closest('.dynamic-field').append(span);
                                            } else if ($('input[name="' + header + '"][type="radio"]').length > 0 && Array.isArray(optionsArray)) {
                                                        inputType = '<div class="form-group row">';
                                                        optionsArray.forEach(function(option) {
                                                            var checked = (values[i] && values[i].split(',').includes(option.toString())) ? 'checked' : '';
                                                            inputType +=
                                                                '<div class="col-md-6">' +
                                                                '<div class="radio-inline mt-2">' +
                                                                '<label class="radio pop-non-edt-val" style="word-break: break-all;" >' +
                                                                '<input type="radio" name="' + header + '_' + i +'" class="'+header +'" value="' + option + '" id="' +
                                                                    header + i + '" ' + checked + '>' + option +
                                                                '<span></span>' +
                                                                '</label>' +
                                                                '</div>' +
                                                                '</div>';
                                                        });

                                                        inputType += '</div>';
                                                        if(i === values.length - 1) {//console.log(i,values.length - 1,'length');
                                                         var minusButton = '<i class="fa fa-plus add_more" id="' +'add_more_'+header +'"></i>';
                                                        } else {
                                                            var minusButton = '<i class="fa fa-minus minus_button remove_more" id="'+header+ i +'"></i>';
                                                        }
                                                        var span = '<div class="row mt-4" id="' + newElementId + '">' +
                                                            '<div class="col-md-10">' + inputType + '</div><div  class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                                                                minusButton + '</div><div></div></div>';
                                                      //  console.log(header, 'header', $('.' + header).find('.col-md-6'));
                                                        $('input[name="' + header + '"]').closest('.dynamic-field').append(span);
                                            } else {
                                                var fieldType =  $('.'+header).attr('type');
                                                var classes = $('.'+header).attr('class');
                                                var classArray = classes.split(' ');
                                                var dateRangeClass = '';
                                                for (var j = 0; j < classArray.length; j++) {
                                                    if (classArray[j] === 'date_range') {
                                                        dateRangeClass = classArray[j];
                                                        break;
                                                    }
                                                }
                                                console.log(fieldType,'fieldType',header,dateRangeClass,values);
                                                if(dateRangeClass == 'date_range') { console.log(fieldType,'fieldType daterange',header,dateRangeClass,values);
                                                  inputType = '<input type="'+fieldType+'" name="' + header +'[]"  class="form-control date_range ' + header + ' white-smoke pop-non-edt-val"  style="cursor:pointer" value="' + values[i] + '" id="' +header + i + '">';
                                                } else {
                                                    inputType = '<input type="'+fieldType+'" name="' + header +'[]"  class="form-control ' + header + ' white-smoke pop-non-edt-val"  value="' + values[i] + '" id="' +header + i + '">';
                                                }
                                                  if(i === values.length - 1) {
                                                         var minusButton = '<i class="fa fa-plus add_more" id="' +'add_more_'+header +'"></i>';
                                                } else {
                                                    var minusButton = '<i class="fa fa-minus minus_button remove_more" id="'+ header+ i +'"></i>';
                                                }
                                                var span = '<div class="row mt-4"  id="' +newElementId+ '">' +
                                                    '<div class="col-md-10">'+ inputType +'</div><div  class="col-md-1 col-form-label text-lg-right pt-0 pb-4" style="margin-left: -1.3rem;">' +
                                                        minusButton +'</div><div></div></div>';
                                                   // console.log(header,'header', $('.'+header).find('.col-md-6'));
                                                    $('input[name="' + header + '[]"]').closest('.dynamic-field').append(span);
                                        }
                                    }
                                    $('.date_range').daterangepicker({
                                        autoUpdateInput: false,
                                    }).on('apply.daterangepicker', function(ev, picker) {
                                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                                    }).attr("autocomplete", "off");
                                } else if ($('input[name="' + header + '[]"]').is(':checkbox')) {
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
                                    $('input[name="parentId"]').val(clientData['parent_id']);
                                    $('input[name="record_old_status"]').val(clientData['claim_status']);
                                      if (header === 'claim_status' && value.includes('CE_')) {
                                            claimStatus = value;
                                            value = value.replace('CE_', '');
                                            $('select[name="claim_status"]').val(claimStatus).trigger('change');
                                        $('#title_status').text(value);
                                    }
                                    if (header == 'id') {
                                        $('input[name="idValue"]').val(value);
                                    }
                                    if (header == 'invoke_date') {
                                        $('input[name="invoke_date"]').val(value);
                                    }
                                    if (header == 'CE_emp_id') {
                                        $('input[name="CE_emp_id"]').val(value);
                                    }
                                    $('textarea[name="' + header + '[]"]').val(value);
                                    $('input[name="' + header + '[]"]').val(value);
                                    $('label[id="' + header + '"]').text(value);
                                    $('input[name="' + header + '"]').val(value);
                                }
                        });

                    }
            });
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
                        url: "{{ url('client_view_details') }}",
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
                            if(data !== '') {
                                var circle = $('<span>').addClass('circle');;
                                var span = $('<span>').addClass('date-label').text(data);
                                    span.prepend(circle);
                                    formattedDatas.push(span);
                            }
                        }); console.log(formattedDatas,'formattedDatas');
                        formattedDatas.forEach(function(span, index) {
                            $('label[id="' + header + '"]').append(span);
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
            $(document).on('click', '#project_hold_save', function(e) {
                    e.preventDefault();
                    var fieldNames = $('#holdFormConfiguration').serializeArray().map(function(input) {
                        return input.name;
                    });
                    var requiredFields = {};
                    var requiredFieldsType = {};
                    var inputclass = [];
                    var inputTypeValue = 0;
                    $('#holdFormConfiguration').find(':input[required], select[required], textarea[required]',
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
                        if($(this).attr("name") !== 'check[]' && $(this).attr("name") !== undefined) {
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
                        var fieldValue = $(this).val();console.log(fieldName,fieldValue,'fieldName');
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
                            }).appendTo('form#holdFormConfiguration');
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
                                document.querySelector('#holdFormConfiguration').submit();

                            } else {
                                //   location.reload();
                            }
                        });

                    } else {
                        return false;
                    }
                });
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
                    getUrlVars()[
                        "parent"] + "&child=" + getUrlVars()["child"];
            })
            $(document).on('click', '.three', function() {
                window.location.href = "{{ url('#') }}";
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
