@extends('layouts.app3')
@section('content')
<div class="card card-custom custom-card">
    <div class="card-body py-2 px-2">
        <div class="d-flex justify-content-between align-items-center m-2">
            <span class="project_header">Report</span>
            <div>
                <button class="btn1" id="reportModalBtn" style="width: 171px;">
                    <img src="{{ asset('assets/svg/generate_report.svg') }}">&nbsp;&nbsp;<strong>Generate Report</strong>
                </button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn1">
                    <img src="{{ asset('assets/svg/export.svg') }}">&nbsp;&nbsp;<strong>Export</strong>
                </button>
            </div>
        </div>
        <div class="text-center" style="height:550px">
            <div style="margin-top: 170px;">
                <img src="{{ asset('assets/svg/human_report.svg') }}">
                <p style="margin-top: 30px">Click Generate report to get response</p>
            </div>
        </div>
    </div>
</div>
<!-- Modal content-->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="margin-top: 7rem">
            <div class="modal-header" style="background-color: #0969C3;height: 84px">
                <h5 class="modal-title" id="modalLabel" style="color: #ffffff;" >Generate report</h5>
                <button type="button" class="close comment_close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #0969C3;height: 84px">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="row form-group">
                            <div class="col-md-12">
                                @php $projectList = App\Http\Helper\Admin\Helpers::projectList(); @endphp
                                {!! Form::select('project_id', $projectList, request()->project_id,
                                    ['class' => 'text-black form-control select2 project_select', 'id' => 'project_id', 'placeholder'=> 'Select Project']
                                ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row form-group">
                            <div class="col-md-12">
                                @if (isset(request()->project_id))
                                    @php $subProjectList = App\Http\Helper\Admin\Helpers::subProjectList(request()->project_id); @endphp
                                    {!! Form::select('sub_project_id', $subProjectList, request()->sub_project_id,
                                        ['class' => 'text-black form-control select2 sub_project_select', 'id' => 'sub_project_id', 'placeholder'=> 'Select Sub Project']
                                    ) !!}
                                @else
                                    @php $subProjectList = []; @endphp
                                    {!! Form::select('sub_project_id', $subProjectList, null,
                                        ['class' => 'text-black form-control select2 sub_project_select', 'id' => 'sub_project_id', 'placeholder'=> 'Select Sub Project']
                                    ) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row form-group">
                            <div class="col-md-12">
                                {!!Form::text('wfcall_completed_date', null,
                                ['class'=>'form-control date_picker1','autocomplete'=>'off','id' => 'date', 'placeholder'=> 'MM-DD-YYYY']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row form-group">
                            <div class="col-md-12">
                                {!! Form::select(
                                    'user',
                                    ['No' => 'No', 'Yes' => 'Yes', 'Partial' => 'Partial'],null,
                                    ['class' => 'text-black form-control select2 user_select', 'id' => 'user', 'placeholder'=> 'Select User']
                                ) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body m-10">
                <p style="text-align: center">Select Projects to Generate Report</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn1" id="project_assign_save">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal content End-->
@endsection
<style>
    .table thead th {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
    .leave_color {
        background: #ff00000f;
    }

    .border-none {
        border: none !important
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

            $(document).on('click', '#reportModalBtn', function(e) {
                $('#reportModal').modal('show');
            });

            $(document).on('change', '#project_id', function() {
                var project_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('reports/get_sub_projects') }}",
                    data: {
                        project_id: project_id
                    },
                    success: function(res) {
                        console.log(res.subProject)
                         $("#sub_project_id").val(res.subProject);
                        var sla_options = '<option value="">-- Select --</option>';
                        $.each(res, function(key, value) {
                            sla_options = sla_options + '<option value="' + key + '">' + value +
                                '</option>';
                        });
                        $("#sub_project_id").html(sla_options);
                        console.log(res);
                    },
                    error: function(jqXHR, exception) {}
                });
            });

            var table = $("#clients_list").DataTable({
                processing: true,
                lengthChange: false,
                searching: false,
                pageLength: 20,
                    columnDefs: [{
                        className: 'details-control',
                        targets: [0],
                        orderable: false,
                    }, ],
                responsive: true

            })
            table.buttons().container().appendTo('.outside');

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
                    '<table id="practice_list" class="inv_head" cellpadding="5" cellspacing="0" border="0" style="width:97%;border-radius: 10px !important;overflow: hidden;margin-left: 1.5rem;">' +
                    '<tr><th></th><th>Sub Project</th><th>Assigned</th> <th>Completed</th> <th>Pending</th><th>On Hold</th> </tr>';
                $.each(subProjects, function(index, val) {
                    console.log(val, 'val',val.client_name,val.sub_project_name );
                    html +=
                        '<tbody><tr class="clickable-row cursor_hand">' +
                        '<td><input type="hidden" value=' + val.client_id + '></td>' +
                        '<td>' + val.sub_project_name + '<input type="hidden" value=' + val.sub_project_id + '></td>' +
                        '<td>' + val.assignedCount + '</td>' +
                        '<td>' + val.CompletedCount + '</td>' +
                        '<td>' + val.PendingCount + '</td>' +
                        '<td>' + val.holdCount + '</td>' +
                        '</tr></tbody>';
                });
                html += '</table>';
                return html;
            }

            $(document).on('click', '.clickable-row', function(e) {
                var clientName = $(this).closest('tr').find('td:eq(0) input').val();
                var subProjectName = $(this).closest('tr').find('td:eq(1) input').val();
                if (!clientName) {
                    console.error('encodedclientname is undefined or empty');
                    return;
                }
                window.location.href = baseUrl + 'projects_assigned/' + btoa(clientName) + '/' + btoa(
                        subProjectName) + "?parent=" +
                    getUrlVars()["parent"] + "&child=" + getUrlVars()["child"];

            })
        })

    </script>
@endpush
