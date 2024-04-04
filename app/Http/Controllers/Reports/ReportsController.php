<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Helper\Admin\Helpers as Helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ReportsController extends Controller
{
    public function reporstIndex(){
        return view('reports.index');
    }
    public function getSubProjects(Request $request){
        try {
            $subProject = Helpers::subProjectList($request->project_id);
            return $subProject;
        } catch (Exception $e) {
            log::debug($e->getMessage());
        }
    }
    public function reportClientAssignedTab(Request $request) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           $client = new Client();
            try {
                $decodedClientName = Helpers::projectName($request->project_id)->project_name;
                $decodedsubProjectName = $request->sub_project_id == null ? Helpers::projectName($request->project_id)->project_name :Helpers::subProjectName($request->project_id, $request->sub_project_id)->sub_project_name;
                $table_name= Str::slug((Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName)),'_');
                $columnsHeader=[];
                if (Schema::hasTable($table_name)) {
                    $column_names = DB::select("DESCRIBE $table_name");
                    $columns = array_column($column_names, 'Field');
                    $columnsToExclude = ['QA_emp_id','updated_at','created_at', 'deleted_at'];
                    $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                        return !in_array($column, $columnsToExclude);
                    });
                }
                return response()->json([
                    'success' => true,
                    'columnsHeader' => $columnsHeader,
                ]);

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/');
        }
    }

    public function reportClientColumnsList(Request $request) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           $client = new Client();
            try {
                $decodedClientName = Helpers::projectName($request->project_id)->project_name;
                $decodedsubProjectName = $request->sub_project_id == null ? Helpers::projectName($request->project_id)->project_name :Helpers::subProjectName($request->project_id, $request->sub_project_id)->sub_project_name;
                $table_name= Str::slug((Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName)).'_datas','_');
                if (isset($request->work_date) && !empty($request->work_date)) {
                    $work_date = explode(' - ', $request->work_date);
                    $start_date = date('Y-m-d', strtotime($work_date[0]));
                    $end_date = date('Y-m-d', strtotime($work_date[1]));
                }else{
                    $start_date = "";
                    $end_date = "";
                }
                if (isset($request->checkedValues)) {
                    if ($request->checkedValues[0] === 'all') {
                        $checkedValues = array_diff($request->checkedValues, ['all']);
                    }else{
                        $checkedValues = $request->checkedValues;
                    }
                    $columnsHeader = implode(',', $checkedValues);
                    $client_data = DB::table($table_name)
                        ->select([
                            DB::raw($columnsHeader),
                            DB::raw("TIME_FORMAT(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, caller_charts_work_logs.start_time, caller_charts_work_logs.end_time)), '%H:%i:%s') AS work_hours")
                        ])
                        ->leftJoin('caller_charts_work_logs', 'caller_charts_work_logs.record_id', '=', $table_name . '.parent_id')
                        ->where(function ($query) use ($start_date, $end_date) {
                            if (!empty($start_date) && !empty($end_date)) {
                                $query->whereBetween('caller_charts_work_logs.start_time', [$start_date, $end_date]);
                            }else{
                                $query;
                            }
                        })
                        ->get();
                } else {
                    $client_data = [];
                }
                if (count($client_data) > 0) {
                    $body_info = '<table class="table table-separate table-head-custom no-footer dtr-column" id="report_list"><thead><tr>';
                    $checkedValues[] = 'work_hours';
                    foreach ($checkedValues as $key => $header) {
                        $body_info .= '<th>' . ucwords(str_replace(['_else_', '_'], ['/', ' '], $header)) . '</th>';
                    }
                    $body_info .= '</tr></thead><tbody>';

                    foreach ($client_data as $row) {
                        $body_info .= '<tr>';
                        foreach ($checkedValues as $header) {
                            $data = isset($row->{$header}) && !empty($row->{$header}) ? $row->{$header} : "--";
                            if ($header === 'claim_status') {
                                $data = str_replace('CE_', '', $data);
                            }
                            $body_info .= '<td>' . $data . '</td>';
                        }
                        $body_info .= '</tr>';
                    }

                    $body_info .= '</tbody></table>';
                } else {
                    $body_info = '<p>No data available</p>';
                }

                return response()->json([
                    'success' => true,
                    'body_info' => $body_info,
                ]);

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/');
        }
    }
}
