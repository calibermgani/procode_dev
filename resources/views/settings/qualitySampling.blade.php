@extends('layouts.app3')
@section('content')
    <div class="card card-custom custom-card" id="quality_sampling">
        <div class="card-body pt-0 pb-2 pl-8" style="background-color: #ffffff !important">
            <div class="row mr-0 ml-0">
                <div class="col-6 mt-4 pt-0 pb-0 pl-0 pr-0">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="project_header" href="" style="margin-left:-1.7rem">
                        <span class="svg-icon svg-icon-primary svg-icon-lg mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" fill="currentColor"
                                class="bi bi-arrow-left project_header_row" viewBox="0 0 16 16"
                                style="width: 1.05rem !important;color: #000000 !important;">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg>
                        </span>Sampling</a>
                </div>
            </div>
            {!! Form::open([
                'url' => url('qa_sampling_store') . '?parent=' . request()->parent . '&child=' . request()->child,
                'id' => 'qa_sampling_form',
                'class' => 'form',
                'enctype' => 'multipart/form-data',
            ]) !!}
            @csrf
            <div class="row mb-2 mt-2 mr-0 ml-0 align-items-center pt-4 pb-3" style="background-color: #F1F1F1;border-radius:0.42rem">
                <div class="col-lg-2 mb-lg-0 mb-6">
                    <label class="required">Project</label>
                    @php $projectList = App\Http\Helper\Admin\Helpers::projectList(); @endphp
                    <fieldset class="form-group mb-1">
                        {!! Form::select('project_id', $projectList, null, [
                            'class' => 'form-control kt_select2_project',
                            'id' => 'project_id',
                            'style' => 'width: 100%;',
                        ]) !!}
                    </fieldset>
                </div>
                <div class="col-lg-2 mb-lg-0 mb-6">
                    <label>Subproject</label>
                    @php $subProjectList = []; @endphp
                    <fieldset class="form-group mb-1">
                        {!! Form::select('sub_project_id', $subProjectList, null, [
                            'class' => 'text-black form-control kt_select2_sub_project',
                            'id' => 'sub_project_list',
                            'style' => 'width: 100%;',
                        ]) !!}
                    </fieldset>
                </div>
                <div class="col-lg-2 mb-lg-0 mb-6">
                    <label>Coder</label>
                    <fieldset class="form-group mb-1">
                        {!! Form::select('coder_emp_id', $coderList, null, [
                            'class' => 'form-control kt_select2_coder',
                            'id' => 'coder_id',
                            'style' => 'width: 100%;; background-color: #ffffff !important;',
                        ]) !!}
                    </fieldset>
                </div>
                <div class="col-lg-2 mb-lg-0 mb-6">
                    <label class="required">QA</label>
                    <fieldset class="form-group mb-1">
                        {!! Form::select('qa_emp_id', $qaList, null, [
                            'class' => 'form-control kt_select2_QA',
                            'id' => 'qa_id',
                            'style' => 'width: 100%;',
                        ]) !!}
                    </fieldset>
                </div>
                <div class="col-lg-1 mb-lg-0 mb-6">
                    {!! Form::label('Percentage', 'Percentage', ['class' => 'required']) !!}
                    <fieldset class="form-group mb-1">
                        <input type="text" name="qa_percentage" id="qa_percentage" class="form-control qa_percentage"
                            autocomplete="nope"  onkeypress = "return event.charCode >= 48 && event.charCode <= 57">
                    </fieldset>
                </div>
                <div class="col-lg-3 mt-8">
                    <button class="btn btn-light-danger" id="clear_submit" tabindex="10" type="button">
                        <span>
                            <span>Clear</span>
                        </span>
                    </button>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-white-black font-weight-bold" id="form_submit"
                        style="background-color: #139AB3">Submit</button>

                </div>
            </div>
            {!! Form::close() !!}
            {{-- <div class="card card-custom" style="border-radius:0px 0px 10px 10px" id="page-loader">
                <div class="card-body pt-4 pb-0 px-5">
                    <div class="mb-0"> --}}
                        <div class="table-responsive pb-4">
                            <table class="table table-separate table-head-custom no-footer dtr-column "
                                id="qa_sampling_table">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Sub Project</th>
                                        <th>Coder</th>
                                        <th>QA</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($qaSamplingList))
                                        @foreach ($qaSamplingList as $data)
                                        @php

                                            $projectName = App\Models\project::where('project_id', $data['project_id'])->first();
                                            if($data['sub_project_id'] != null) {
                                                $subProjectName = App\Models\subproject::where('project_id',$data['project_id'])
                                                    ->where('sub_project_id', $data['sub_project_id'])
                                                    ->first();
                                            } else {
                                                $subProjectName = '--';
                                            }
                                            $coderName = $data["coder_emp_id"] != NULL ? App\Http\Helper\Admin\Helpers::getUserNameById($data["coder_emp_id"]) : '--';
                                            $qaName = $data["qa_emp_id"] != NULL ? App\Http\Helper\Admin\Helpers::getUserNameById($data["qa_emp_id"]) : '--';
                                        @endphp
                                            <tr>
                                                <td>{{$projectName->project_name}}</td>
                                                <td>{{ $subProjectName == '--' ? '--' : $subProjectName->sub_project_name }}</td>
                                                <td>{{$coderName == NULL ? '--' :  $coderName}}</td>
                                                <td>{{$qaName == NULL ? '--' : $qaName}}</td>
                                                <td>{{$data['qa_percentage']. '%'}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    {{-- </div>
                </div>
            </div> --}}
        </div>
    @endsection
    @push('view.scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#qa_sampling_table').DataTable({
                    processing: true,
                    lengthChange: false,
                    searching: false,
                    pageLength: 20,

                });
                $(document).on('change', '#project_id', function() {
                    var project_id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('sub_project_list') }}",
                        data: {
                            project_id: project_id
                        },
                        success: function(res) {
                            subprojectCount = Object.keys(res.subProject).length;
                            var myArray = res.existingSubProject;
                            var sla_options = '<option value="">-- Select --</option>';
                            $.each(res.subProject, function(key, value) {
                                sla_options += '<option value="' + key + '">' + value +
                                    '</option>';
                            });
                            $('select[name="sub_project_id"]').html(sla_options);
                        },
                        error: function(jqXHR, exception) {}
                    });
                });

                $(document).on('click', '#form_submit', function(e) {
                    e.preventDefault();

                    var project_id = $('#project_id');
                    var qa_id = $('#qa_id');
                    var qa_percentage = $('#qa_percentage');
                    if (project_id.val() == '' || qa_id.val() == '' || qa_percentage.val() == '') {
                        if (project_id.val() == '') {
                            project_id.next('.select2').find(".select2-selection").css('border-color', 'red');
                        } else {
                            project_id.next('.select2').find(".select2-selection").css('border-color', '');
                        }
                        if (qa_id.val() == '') {
                            qa_id.next('.select2').find(".select2-selection").css('border-color', 'red');
                        } else {
                            qa_id.next('.select2').find(".select2-selection").css('border-color', '');
                        }
                        if (qa_percentage.val() == '') {
                            qa_percentage.css('border-color', 'red');
                        } else {
                            qa_percentage.css('border-color', '');
                        }
                        return false;
                    }
                    document.querySelector('#qa_sampling_form').submit();
                });
            });
        </script>
    @endpush
