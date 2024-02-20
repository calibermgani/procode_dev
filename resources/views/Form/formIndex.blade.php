@extends('layouts.app3')

@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Form Creation</h5>
            </div>
        </div>
        <div class="d-flex align-items-start">
            <a class="btn btn-light-primary font-weight-bolder btn-sm mr-5"
                href="{{ url('form_configuration_list') }}?parent={{ request()->parent }}&child={{ request()->child }}">List</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open([
        'url' => url('form_configuration_store') . '?parent=' . request()->parent . '&child=' . request()->child,
        'method' => 'POST',
        'id' => 'formConfiguration',
        'enctype' => 'multipart/form-data',
    ]) !!}
    @csrf
    <div class="row">
        <div class="col-2">
                <div class="d-flex flex-column mt-4 mb-2" style="flex-wrap:wrap">

                    <label class="col-form-label px-3 required">Project</label>
                    @php $projectList = App\Http\Helper\Admin\Helpers::projectList();
                    @endphp
                    <div class="form-group mb-1">
                        {!! Form::select('project_id', $projectList, null, [
                            'class' => 'form-control js-client-name',
                            'id' => 'project_list',
                        ]) !!}

                    </div>
                </div>
        </div>
        <div class="col-2">
                <div class="d-flex flex-column mt-4 mb-2" style="flex-wrap:wrap">
                    <label class="col-form-label px-3 required">Sub Project</label>
                    <div class="form-group mb-1">
                        @php
                            $subProjectList = [];

                        @endphp
                        {!! Form::select('sub_project_id', $subProjectList, null, [
                            'class' => 'form-control js-client-name',
                            'id' => 'sub_project_list',
                        ]) !!}
                    </div>
                </div>
            </div>
    </div>
    <div class="card-body pt-0 pb-2 pl-0">
        <div class="row" id="form_div">
            <div class="col-md-12">
                <div id="form_field">
                    <div class="col-md-12 mb-5"
                        style="background: #fcfcfc; padding: 5px 10px 1px 10px;border-radius:5px; border: 1px solid #28bb9f2e; "
                        id="form_append">
                        {{-- <div> --}}
                            <div class="col-form-label text-lg-right pt-0 pb-4">
                                <i class="fa fas fa-plus text-success icon-circle1 ml-1" id="add_more"></i>
                            </div>
                            <div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label class="required">Label</label>
                                        <div class="form-group mb-1">
                                            <input type="text" id="label_name" name="label_name[]"
                                                class="text-black form-control label_name" value=""
                                                oninput="validateInput(this)">

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Input Type</label>
                                        <div class="form-group mb-1">
                                            {!! Form::select(
                                                'input_type[]',
                                                [
                                                    'text' => 'Text Box',
                                                    'select' => 'Drop Down',
                                                    'checkbox' => 'CheckBox',
                                                    'radio' => 'Radio',
                                                    'date' => 'Date',
                                                    'date_range' => 'Date Range',
                                                    'textarea' => 'Text Area',
                                                ],
                                                null,
                                                [
                                                    'class' => 'text-black form-control input_type',
                                                    'id' => 'input_type_id_0',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2 options_div" style="display:none" id="options_div_0">
                                        <label class="options_name_label required" id="options_name_label_0"
                                            style="display:none">Options</label>
                                        <div class="form-group mb-1">
                                            <input type="text" id="options_name_0" name="options_name[]"
                                                class="text-black form-control options_name" value=""
                                                style="display:none">

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Field Type</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="field_type1" value="editable">
                                                <span></span>Editable</label>
                                            <label class="radio">
                                                <input type="radio" name="field_type1" value="non_editable"checked>
                                                <span></span>Non-Editable</label>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Field Type1</label>
                                        <div class="radio-inline">
                                            <label class="radio" style="padding-top: 1px;">
                                                <input type="radio" name="field_type2"
                                                    value="multiple" /><span></span>Multiple

                                            </label>
                                            <label class="radio" style="padding-top: 1px;">
                                                <input type="radio" name="field_type2" value="single"
                                                    checked /><span></span>Single

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Field Type2</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="field_type3" value="mandatory" />
                                                <span></span>Mandatory
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="field_type3" value="non-mandatory" checked />
                                                <span></span>Non-Mandatory
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Field Type3</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="field_type4" value="popup_visible" checked/>
                                                <span></span>Visible
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="field_type4" value="popup_non_visible"  />
                                                <span></span>Non Visible
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-5">
            <button type="submit" class="btn btn-primary font-weight-bold" id="formUpdate_save">Submit</button>&nbsp;&nbsp;
            <button class="btn btn-secondary btn-secondary--icon" id="clear_submit" tabindex="10" type="button">
                <span>
                    <i class="la la-close"></i>
                    <span>Clear</span>
                </span>
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('view.scripts')
    <script>
        function validateInput(input) {
            var regex = /^[a-zA-Z0-9\s\/]*$/;
            var value = input.value;

            if (!regex.test(value)) {
                // alert("Only alphanumeric characters, spaces, and slashes are allowed.");
                input.value = value.replace(/[^a-zA-Z0-9\s\/]/g, '');
            }
        }
        $(document).ready(function() {

            var j = 0;

            $('#add_more').click(function() {
                j++;
                var date = moment().format('YYYY-MM-DD');
                var min_date = moment().format('YYYY-MM-DD');
                $('#form_div').append(
                    '<div class="col-md-12"><div id="form_field"> <div class="col-md-12 mb-5" style="background: #fcfcfc; padding: 5px 10px 1px 10px;border-radius:5px; border: 1px solid #28bb9f2e; " id="form_append' +
                    j +
                    '"><div style=""><div class="col-form-label text-lg-right pt-0 pb-4"><i class="fa fas fa-minus text-danger icon-circle1 ml-1 remove_more" id="' +
                    j + '"></i></div><div id="form_div' + j +
                    '"><div class="row form-group"><div class="col-md-2"><label class="required">Label</label><div class="form-group mb-1"><input type="text" id="label_name' +
                    j +
                    '" name="label_name[]" class="text-black form-control label_name"> </div></div><div class="col-md-2"><label>Input Type</label><div class="form-group mb-1"><select  class="text-black form-control input_type" name="input_type[]" id="input_type_id_' +
                    j +
                    '"><option value="text">Text Box</option><option value="select">Drop Down</option><option value="checkbox">CheckBox</option><option value="radio">Radio</option><option value="date">Date</option><option value="date_range">Date Range</option><option value="textarea">Text Area</option></select></div></div> <div class="col-md-2 options_div" style="display:none" id="options_div_' +
                    j +
                    '"><label class="options_name_label required" style="display:none"  id="options_name_label_' +
                    j +
                    '">Options</label><div class="form-group mb-1"><input type="text" name="options_name[]" class="text-black form-control options_name" value="" style="display:none"  id="options_name_' +
                    j +
                    '"></div></div><div class="col-md-2"><label>Field Type</label><div class="radio-inline"><label class="radio"><input type="radio" name="field_type1_' +
                    j + '" value="editable" id="editable' +
                    j +
                    '"><span></span>Editable</label><label class="radio"><input type="radio" name="field_type1_' +
                    j + '" value="non_editable" id="non_editable' +
                    j +
                    '"  checked><span></span>Non-Editable</label></div></div><div class="col-md-2"><label>Field Type1</label>  <div class="radio-inline"><label class="radio"><input type="radio" name="field_type2_' +
                    j + '" value="multiple" id="multiple' +
                    j +
                    '" ><span></span>Multiple  </label><label class="radio"><input type="radio" name="field_type2_' +
                    j + '" value="single" id="single' +
                    j +
                    '"  checked><span></span>Single  </label></div></div><div class="col-md-2"><label>Field Type2</label>  <div class="radio-inline"><label class="radio"><input type="radio" name="field_type3_' +
                    j +
                    '" value="mandatory" /><span></span>Mandatory</label><label class="radio"><input type="radio" name="field_type3_' +
                    j +
                    '" value="non-mandatory" checked /><span></span>Non-Mandatory</label></div></div><div class="col-md-2"><label>Field Type3</label><div class="radio-inline"><label class="radio"><input type="radio" name="field_type4_' +
                    j +
                    '" value="popup_visible" checked/><span></span>Visible</label><label class="radio"><input type="radio" name="field_type4_' +
                    j +
                    '" value="popup_non_visible"  /><span></span>Non Visible</label></div></div></div></div></div></div></div></div></div>'
                );
            });

            $(document).on('click', '.remove_more', function() {
                var button_id = $(this).attr("id");
                $('#form_append' + button_id + '').remove();
            });

            $(document).on('change', '#project_list', function() {
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

                        var myArray = res.existingSubProject;
                        var sla_options = '<option value="">-- Select --</option>';
                        $.each(res.subProject, function(key, value) {
                            sla_options += '<option value="' + key + '" ' +
                                                (myArray.length >0 && $.inArray(key, myArray) !== -1 ? 'disabled' :
                                                    '') +
                                                '>' + value +
                                '</option>';
                        });
                        $("#sub_project_id").html(sla_options);
                        $('select[name="sub_project_id"]').html(sla_options);
                    },
                    error: function(jqXHR, exception) {}
                });
            });
            $(document).on('change', '.input_type', function() {
                var splittedValues = $(this).attr('id').split('_');
                var lastElement = splittedValues[splittedValues.length - 1];
                var input_type = $(this).val();
                var select_id = ($(this).attr('id'));
                if (input_type == "select" || input_type == "checkbox" || input_type == "radio") {
                    $('#options_div_' + lastElement).css('display', 'block');
                    $('#options_name_label_' + lastElement).css('display', 'block');
                    $('#options_name_' + lastElement).css('display', 'block');
                } else {
                    $('#options_div_' + lastElement).css('display', 'none');
                    $('#options_name_label_' + lastElement).css('display', 'none');
                    $('#options_name_' + lastElement).css('display', 'none');
                }
            });
            $(document).on('click', '#formUpdate_save', function() {
                var project_id = $('#project_list');
                var sub_project_id = $('#sub_project_list');
                var label_name = $('.label_name');
                var input_type = $('.input_type');
                if (project_id.val() == '' || sub_project_id.val() == '') {
                    if (project_id.val() == '') {
                        project_id.next('.select2').find(".select2-selection").css('border-color', 'red');
                    } else {
                        project_id.next('.select2').find(".select2-selection").css('border-color', '');
                    }
                    if (sub_project_id.val() == '') {
                        sub_project_id.next('.select2').find(".select2-selection").css('border-color',
                            'red');
                    } else {
                        sub_project_id.next('.select2').find(".select2-selection").css('border-color', '');
                    }

                    return false;
                } else {
                    var labelNameValue;
                    var inputTypeValue;
                    label_name.each(function() {
                        var label_id = $(this).attr('id');
                        if ($('#' + label_id).val() == '') {
                            $('#' + label_id).css('border-color', 'red');
                            labelNameValue = 1;
                            return false;
                        } else {
                            $('#' + label_id).css('border-color', '');
                            labelNameValue = 0;
                        }
                    });

                    input_type.each(function() {
                        var input_type_id = $(this).attr('id');
                        var splittedValues = $(this).attr('id').split('_');
                        var lastElement = splittedValues[splittedValues.length - 1];
                        console.log($('#' + input_type_id).val(), input_type_id);
                        if (($('#' + input_type_id).val() == 'select' || $('#' + input_type_id)
                                .val() == 'checkbox' || $('#' + input_type_id).val() == "radio") &&
                            $('#options_name_' + lastElement).val() == '') {
                            $('#options_name_' + lastElement).css('border-color', 'red');
                            inputTypeValue = 1;
                            return false;
                        } else {
                            $('#options_name_' + lastElement).css('border-color', '');
                            inputTypeValue = 0;
                        }
                    });
                    console.log(labelNameValue, 'labelNameValue', inputTypeValue);
                    var fieldTypes = $('input[name^="field_type1"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    var fieldTypes_1 = $('input[name^="field_type2"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    var fieldTypes_2 = $('input[name^="field_type3"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    var fieldTypes_3 = $('input[name^="field_type4"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    for (var i = 0; i < fieldTypes.length; i++) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'field_type[]',
                            value: fieldTypes[i]
                        }).appendTo('form#formConfiguration');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'field_type_1[]',
                            value: fieldTypes_1[i]
                        }).appendTo('form#formConfiguration');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'field_type_2[]',
                            value: fieldTypes_2[i]
                        }).appendTo('form#formConfiguration');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'field_type_3[]',
                            value: fieldTypes_3[i]
                        }).appendTo('form#formConfiguration');
                    }
                    if (labelNameValue == 0 && inputTypeValue == 0) {
                        e.preventDefault();
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
                                // If the user clicks "OK" in the SweetAlert dialog, submit the form
                                document.querySelector('#formConfiguration').submit();

                            } else {
                                location.reload();
                            }
                        });
                    } else {
                        return false;
                    }
                }
            })
        });
    </script>
@endpush