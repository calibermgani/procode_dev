@extends('layouts.app3')
@section('subheader')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Project Creation List</h5>
            </div>
        </div>
        <div class="d-flex align-items-start">
            <a class="btn btn-light-primary font-weight-bolder btn-sm mr-5"
                href="{{ url('form_creation') }}?parent={{ request()->parent }}&child={{ request()->child }}">Add</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap  py-3 pb-0  border-bottom">
            <h3 class="card-title align-items-start flex-column">
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
                    <span style="color:#0e969c">Project Creation List</span>
                </span>
            </h3>
        </div>

        <div class="card-body pb-4 pt-3">
            <div class="row">
                <div class="col-lg-12 py-2 px-1">
                    <div class="tab-content px-5">
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container-fluid px-0">
                                <div class="card-body pt-0 px-0">
                                    <div class="row">
                                        <div class="col-md-12  px-0 mb-5">
                                            <div class="table-responsive pb-4">
                                                <table
                                                    class="table table-separate tb-cursor table-head-custom DtableModels no-footer  dataTable"
                                                    id="formConfigurationLsit">
                                                    <thead>
                                                        <tr>
                                                            <th>Project Name</th>
                                                            <th>Sub Project Name</th>
                                                            <th>Column Fields</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($formConfiguration))
                                                            @foreach ($formConfiguration as $data)
                                                                @php
                                                                    $project_name_encode = App\Http\Helper\Admin\Helpers::encodeAndDecodeID($data->project_name);
                                                                    $sub_project_name_encode = App\Http\Helper\Admin\Helpers::encodeAndDecodeID($data->sub_project_name);
                                                                @endphp
                                                                {{-- <tr data-href="{{url('form_creation')}}?parent={{request()->parent}}&child={{request()->child}}"> --}}
                                                                <tr
                                                                    data-href="{{ route('formEdit', ['parent' => request()->parent, 'child' => request()->child, 'project_name' => $project_name_encode, 'sub_project_name' =>  $sub_project_name_encode]) }}">
                                                                    <td>{{ $data->project_name }}</td>
                                                                    <td>{{ $data->sub_project_name }}</td>
                                                                    <td>{{ $data->label_names }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
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
    </div>
@endsection

@push('view.scripts')
    <script>
        $(document).ready(function() {
            $('#formConfigurationLsit').DataTable({
                // paging: false,
                lengthChange: false,
                searching: true,
                pageLength: 20,
            });
            $('tr[data-href]').click(function() {
                var url = $(this).data('href');
                window.location.href = url;
            });
        });
    </script>
@endpush
