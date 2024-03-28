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
                $decodedsubProjectName = Helpers::subProjectName($request->project_id, $request->sub_project_id)->sub_project_name;
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
            return redirect('/login');
        }
    }

    public function reportClientColumnsList(Request $request) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           $client = new Client();
            try {
                $decodedClientName = Helpers::projectName($request->project_id)->project_name;
                $decodedsubProjectName = Helpers::subProjectName($request->project_id, $request->sub_project_id)->sub_project_name;
                $table_name= Str::slug((Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName)),'_');
                if (isset($request->checkedValues)) {
                    $columnsHeader = implode(',', $request->checkedValues);
                    $client_data = DB::table($table_name)->select(DB::raw($columnsHeader))->get();
                } else {
                    $client_data = [];
                }
                if (count($client_data) > 0) {
                    $body_info = '<table class="table table-separate table-head-custom no-footer dtr-column clients_list_filter" id="report_list"><thead><tr>';
                        foreach ($request->checkedValues as $key => $header) {
                            $body_info .= '<th>' . ucwords(str_replace(['_else_', '_'], ['/', ' '], $header)) . '</th>';
                        }
                    $body_info .= '</tr><thead><tbody><tr>';
                    foreach ($client_data as $row) {
                        foreach ($request->checkedValues as $header) {
                            if (isset($row->{$header}) && !empty($row->{$header})) {
                                $data = $row->{$header};
                            } else {
                                $data ="--";
                            }
                            $body_info .= '<td>' . $data . '</td>';
                        }
                    }
                    $body_info .= '</tr></tbody></table>';
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
            return redirect('/login');
        }
    }
}
