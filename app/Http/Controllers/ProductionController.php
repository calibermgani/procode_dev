<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App\Http\Helper\Admin\Helpers as Helpers;
use Illuminate\Support\Facades\Session;
use App\Models\InventoryWound;
use App\Models\InventoryWoundDuplicate;
use App\Models\project;
use App\Models\subproject;
use App\Models\formConfiguration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\CallerChartsWorkLogs;

class ProductionController extends Controller
{
    public function dashboard() {
       if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
            return view('productions/dashboard');
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clients() {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $projects = project::where('status','Active')->get();
                return view('productions/clients',compact('projects'));
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function getSubProjects(Request $request) {
        try {
            $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
            $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";

            $subprojects = subproject::with(['clientName'])->where('project_id',$request->project_id)->where('status','Active')->get();
            $subProjectsWithCount = [];
            foreach ($subprojects as $key => $data) {
                $subProjectsWithCount[$key]['client_id'] =$data->clientName->id;
                $subProjectsWithCount[$key]['client_name'] =$data->clientName->project_name;
                $subProjectsWithCount[$key]['sub_project_id'] =$data->id;
                $subProjectsWithCount[$key]['sub_project_name'] = $data->sub_project_name;
                $projectName = $subProjectsWithCount[$key]['client_name'];
                $model_name = ucfirst($projectName) . ucfirst($subProjectsWithCount[$key]['sub_project_name']);
                // dd($model_name);

                    $modelClass = "App\\Models\\" .  $model_name;
                    if ($loginEmpId && $empDesignation == "Administrator") {
                        if (class_exists($modelClass)) {
                            $subProjectsWithCount[$key]['assignedCount'] = $modelClass::where('claim_status','CE_Assigned')->count();
                            $subProjectsWithCount[$key]['CompletedCount'] = $modelClass::where('claim_status','CE_Completed')->count();
                            $subProjectsWithCount[$key]['PendingCount'] = $modelClass::where('claim_status','CE_Pending')->count();
                            $subProjectsWithCount[$key]['holdCount'] = $modelClass::where('claim_status','CE_Hold')->count();
                        } else {
                            $subProjectsWithCount[$key]['assignedCount'] ='--';
                            $subProjectsWithCount[$key]['CompletedCount'] = '--';
                            $subProjectsWithCount[$key]['PendingCount'] = '--';
                            $subProjectsWithCount[$key]['holdCount'] = '--';
                        }
                    } else if($loginEmpId) {
                        if (class_exists($modelClass)) {
                            $subProjectsWithCount[$key]['assignedCount'] = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                            $subProjectsWithCount[$key]['CompletedCount'] = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                            $subProjectsWithCount[$key]['PendingCount'] = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                            $subProjectsWithCount[$key]['holdCount'] = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                        } else {
                            $subProjectsWithCount[$key]['assignedCount'] ='--';
                            $subProjectsWithCount[$key]['CompletedCount'] = '--';
                            $subProjectsWithCount[$key]['PendingCount'] = '--';
                            $subProjectsWithCount[$key]['holdCount'] = '--';
                        }
                     }

            }
//dd($subProjectsWithCount);
            return response()->json(['subprojects' => $subProjectsWithCount]);
        } catch (Exception $e) {
            log::debug($e->getMessage());
        }
    }

    public function handleRowClick(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $databaseConnection = Str::lower($request->client_name);
                Config::set('database.connections.mysql.database', $databaseConnection);
                //$result = DB::connection($databaseConnection)->table('users')->where('id', 1)->first();
                return response()->json(['success' => true]);
                } catch (Exception $e) {
                    log::debug($e->getMessage());
                }
        } else {
            return redirect('/login');
        }
    }
    public function clientTabs($clientName) {
        try {
            $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
            $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
            $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
            $databaseConnection = Str::lower($decodedClientName);
            Config::set('database.connections.mysql.database',$databaseConnection);

            if ($loginEmpId && $empDesignation == "Administrator") {
                $assignedProjectDetails = InventoryWound::where('status','CE_Inprocess')->orderBy('id','desc')->get();
                $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->orderBy('id','desc')->get();
                $completedProjectDetails = InventoryWound::where('status','CE_Completed')->orderBy('id','desc')->get();
                $holdProjectDetails = InventoryWound::where('status','CE_Hold')->orderBy('id','desc')->get();
            } elseif ($loginEmpId) {
                $assignedProjectDetails = InventoryWound::where('status','CE_Inprocess')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                $completedProjectDetails = InventoryWound::where('status','CE_Completed')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                $holdProjectDetails = InventoryWound::where('status','CE_Hold')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
            }
            if ($empDesignation == "Administrator") {
               $duplicateProjectDetails = InventoryWoundDuplicate::whereNotIn('status',['agree','dis_agree'])->orderBy('id','desc')->get();
            } else {
                $duplicateProjectDetails = [];
            }
            return view('productions/clientAssignedTab',compact('assignedProjectDetails','completedProjectDetails','holdProjectDetails','duplicateProjectDetails','databaseConnection'));
        } catch (Exception $e) {
            log::debug($e->getMessage());
        }
    }
    public function clientAssignedTab($clientName,$subProjectName) {

         if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            $client = new Client();
            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
                $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
                $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
                // $modelClass = "App\\Models\\" . 'Inventory'.ucfirst($decodedsubProjectName);
                 //$databaseConnection = Str::lower($decodedClientName);
               // Config::set('database.connections.mysql.database',$databaseConnection);
                $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
                // $column_names = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'");
                // $columns = array_column($column_names, 'COLUMN_NAME');
                // $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
                $column_names = DB::select("DESCRIBE $table_name");
                $columns = array_column($column_names, 'Field');
                $columnsToExclude = ['QA_emp_id','updated_at','created_at', 'deleted_at'];
                $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                    return !in_array($column, $columnsToExclude);
                });
                $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
                $modelClassDatas = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Datas';
                $assignedProjectDetails = collect();$assignedDropDown=[];$dept= Session::get('loginDetails')['userInfo']['department']['id'];$existingCallerChartsWorkLogs = [];
                $duplicateCount = 0; $assignedCount=0; $completedCount = 0; $pendingCount = 0;   $holdCount =0;$reworkCount = 0;
                if ($loginEmpId && $empDesignation == "Administrator") {
                    // if (Schema::hasTable($table_name)) {
                    //    $assignedProjectDetails = DB::table($table_name)->get();
                    // }
                    if (class_exists($modelClass)) {
                        // if (class_exists($modelClassDatas) && class_exists($modelClass)) {
                        // $assignedProjectDetails = $modelClassDatas::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                        // if(count($assignedProjectDetails) == 0) {
                        //     $assignedProjectDetails = $modelClass::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                        // }
                        $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Duplicates';
                        $assignedProjectDetails = $modelClass::whereIn('claim_status',['CE_Assigned','CE_Inprocess'])->orderBy('id','desc')->limit(2000)->get();
                        $assignedDropDownIds = $modelClass::where('claim_status','CE_Assigned')->select('CE_emp_id')->groupBy('CE_emp_id')->pluck('CE_emp_id')->toArray();
                        $assignedCount = $modelClass::where('claim_status','CE_Assigned')->count();
                        $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                        $pendingCount = $modelClass::where('claim_status','CE_Pending')->count();
                        $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                        $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                        $duplicateCount = $modelClassDuplcates::count();
                        $payload = [
                            'token' => '1a32e71a46317b9cc6feb7388238c95d',
                            'client_id' => $decodedProjectName
                        ];

                        // Make a POST request to the API endpoint with JSON payload
                        $response = $client->request('POST', 'http://dev.aims.officeos.in/api/v1_users/get_resource_name', [
                            'json' => $payload
                        ]);
                        if ($response->getStatusCode() == 200) {
                            // Get response body
                            $data = json_decode($response->getBody(), true);

                            // Now you have the data from the API response
                            // You can pass this data to your view or process it further
                          //  return $data;
                        } else {
                            // Handle unsuccessful response
                            return response()->json(['error' => 'API request failed'], $response->getStatusCode());
                        }
                        $assignedDropDown = $data['userDetail'];
                    }
                    // $assignedProjectDetails = InventoryWound::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                    //$assignedProjectDetails = $modelClass::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                    if (class_exists($modelClass)) {
                       $assignedProjectDetails = $modelClass::whereIn('claim_status',['CE_Assigned','CE_Inprocess'])->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->limit(2000)->get();
                       $existingCallerChartsWorkLogs = CallerChartsWorkLogs::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->where('end_time',NULL)->pluck('record_id')->toArray();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                    }
                }
                $popUpHeader =  formConfiguration::groupBy(['project_id', 'sub_project_id'])
                ->where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)
                ->select('project_id', 'sub_project_id')
                ->first();
                $popupNonEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->whereIn('user_type',[3,$dept])->where('field_type','non_editable')->where('field_type_3','popup_visible')->get();
                $popupEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->whereIn('user_type',[3,$dept])->where('field_type','editable')->where('field_type_3','popup_visible')->get();

                    return view('productions/clientAssignedTab',compact('assignedProjectDetails','columnsHeader','popUpHeader','popupNonEditableFields','popupEditableFields','modelClass','clientName','subProjectName','assignedDropDown','existingCallerChartsWorkLogs','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientPendingTab($clientName,$subProjectName) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           try {
               $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
               $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
               $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
               $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
               $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
               $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
               $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
               $column_names = DB::select("DESCRIBE $table_name");
               $columns = array_column($column_names, 'Field');
               $columnsToExclude = ['id','QA_emp_id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect(); $duplicateCount = 0;
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $pendingProjectDetails = $modelClass::where('claim_status','CE_Pending')->orderBy('id','desc')->get();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                       $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Duplicates';
                       $duplicateCount = $modelClassDuplcates::count();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $pendingProjectDetails = $modelClass::where('claim_status','CE_Pending')->orderBy('id','desc')->get();
                      $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                      $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                      $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                      $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                      $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                   }
                 }

                return view('productions/clientPendingTab',compact('pendingProjectDetails','columnsHeader','clientName','subProjectName','modelClass','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    public function clientHoldTab($clientName,$subProjectName) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           try {
               $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
               $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
               $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
               $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
               $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
               $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
               $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
               $column_names = DB::select("DESCRIBE $table_name");
               $columns = array_column($column_names, 'Field');
               $columnsToExclude = ['id','QA_emp_id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();$duplicateCount = 0;
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $holdProjectDetails = $modelClass::where('claim_status','CE_Hold')->orderBy('id','desc')->get();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                       $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Duplicates';
                       $duplicateCount = $modelClassDuplcates::count();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $holdProjectDetails = $modelClass::where('claim_status','CE_Hold')->orderBy('id','desc')->get();
                      $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                      $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                      $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                      $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                      $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                   }
                 }

                return view('productions/clientOnholdTab',compact('holdProjectDetails','columnsHeader','clientName','subProjectName','modelClass','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    public function clientCompletedTab($clientName,$subProjectName) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           try {
               $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
               $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
               $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
               $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
               $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
               $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
               $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
               $column_names = DB::select("DESCRIBE $table_name");
               $columns = array_column($column_names, 'Field');
               $columnsToExclude = ['QA_emp_id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();$duplicateCount = 0;
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $completedProjectDetails = $modelClass::where('claim_status','CE_Completed')->orderBy('id','desc')->get();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                       $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Duplicates';
                       $duplicateCount = $modelClassDuplcates::count();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $completedProjectDetails = $modelClass::where('claim_status','CE_Completed')->orderBy('id','desc')->get();
                      $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                      $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                      $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                      $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                      $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                   }
                 }
                 $dept= Session::get('loginDetails')['userInfo']['department']['id'];
                 $popUpHeader =  formConfiguration::groupBy(['project_id', 'sub_project_id'])
                 ->where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)
                 ->select('project_id', 'sub_project_id')
                 ->first();
                 $popupNonEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->whereIn('user_type',[3,$dept])->where('field_type','non_editable')->where('field_type_3','popup_visible')->get();
                 $popupEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->whereIn('user_type',[3,$dept])->where('field_type','editable')->where('field_type_3','popup_visible')->get();

                return view('productions/clientCompletedTab',compact('completedProjectDetails','columnsHeader','clientName','subProjectName','modelClass','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount','popUpHeader','popupNonEditableFields','popupEditableFields'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    public function clientReworkTab($clientName,$subProjectName) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           try {
               $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
               $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
               $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
               $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
               $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
               $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
               $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
               $column_names = DB::select("DESCRIBE $table_name");
               $columns = array_column($column_names, 'Field');
               $columnsToExclude = ['id','QA_emp_id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();$duplicateCount = 0;
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $revokeProjectDetails = $modelClass::where('claim_status','Revoke')->orderBy('id','desc')->get();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                       $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Duplicates';
                       $duplicateCount = $modelClassDuplcates::count();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $revokeProjectDetails = $modelClass::where('claim_status','Revoke')->orderBy('id','desc')->get();
                      $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                      $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                      $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                      $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                      $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                   }
                 }

                return view('productions/clientReworkTab',compact('revokeProjectDetails','columnsHeader','clientName','subProjectName','modelClass','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    public function clientDuplicateTab($clientName,$subProjectName) {

        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
           try {
               $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
               $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
               $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
               $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
               $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
               $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
               $table_name= Str::lower($decodedClientName).'_'.Str::lower($decodedsubProjectName);
               $column_names = DB::select("DESCRIBE $table_name");
               $columns = array_column($column_names, 'Field');
               $columnsToExclude = ['id','QA_emp_id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClassDuplcates = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName)."Duplicates";
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $duplicateProjectDetails = collect();$duplicateCount = 0;
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClassDuplcates)) {
                        //   $duplicateProjectDetails =  $modelClass::whereNotIn('status',['agree','dis_agree'])->orderBy('id','desc')->get();
                        $duplicateProjectDetails =  $modelClassDuplcates::orderBy('id','desc')->limit(10)->get();
                        $assignedCount =  $modelClass::where('claim_status','CE_Assigned')->count();
                        $completedCount = $modelClass::where('claim_status','CE_Completed')->count();
                        $pendingCount =   $modelClass::where('claim_status','CE_Pending')->count();
                        $holdCount = $modelClass::where('claim_status','CE_Hold')->count();
                        $reworkCount = $modelClass::where('claim_status','Revoke')->count();
                        $duplicateCount = $modelClassDuplcates::count();
                   }
                } elseif ($loginEmpId) {
                    if (class_exists($modelClassDuplcates)) {
                       $duplicateProjectDetails = $modelClassDuplcates::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->limit(2000)->get();
                       $assignedCount = $modelClass::where('claim_status','CE_Assigned')->where('CE_emp_id',$loginEmpId)->count();
                       $completedCount = $modelClass::where('claim_status','CE_Completed')->where('CE_emp_id',$loginEmpId)->count();
                       $pendingCount = $modelClass::where('claim_status','CE_Pending')->where('CE_emp_id',$loginEmpId)->count();
                       $holdCount = $modelClass::where('claim_status','CE_Hold')->where('CE_emp_id',$loginEmpId)->count();
                       $reworkCount = $modelClass::where('claim_status','Revoke')->where('CE_emp_id',$loginEmpId)->count();
                    }
                }

                return view('productions/clientDuplicateTab',compact('duplicateProjectDetails','columnsHeader','clientName','subProjectName','modelClass','assignedCount','completedCount','pendingCount','holdCount','reworkCount','duplicateCount'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    public function clientsDuplicateStatus(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                dd($request->all());
                $status = $request['dropdownStatus'];
                $databaseConnection = $request['dbConn'];
                Config::set('database.connections.mysql.database',$databaseConnection);
                foreach($request['checkedRowValues'] as $data) {
                    $ticketNumber = InventoryWoundDuplicate::where('ticket_number',$data['value'])->first();
                    $ticketNumber->update(['status' => $status]);
                }
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public function clientsStore(Request $request,$clientName,$subProjectName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data = $request->all();
                $decodedProjectName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $decodedPracticeName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
                $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
                $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
                $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Datas';
                $data = [];
                foreach ($request->except('_token', 'parent', 'child') as $key => $value) {
                      if (is_array($value)) {
                         $data[$key] = implode(',', $value);
                    } else {
                          $data[$key] = $value;
                    }
                }
                $data['parent_id'] = $data['idValue'];
                $modelClass::create($data);
                $originalModelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
                $record = $originalModelClass::where('id', $data['parent_id'])->first();//dd($record);
                $record->update( ['claim_status' => $data['claim_status']] );
                $currentTime = Carbon::now();
                $callChartWorkLogExistingRecord = CallerChartsWorkLogs::where('record_id', $data['parent_id'])
                ->where('project_id', $decodedProjectName)
                ->where('sub_project_id', $decodedPracticeName)
                ->where('emp_id', Session::get('loginDetails')['userDetail']['emp_id'])->first();
                $callChartWorkLogExistingRecord->update( ['end_time' => $currentTime->format('Y-m-d H:i:s')] );
                return redirect('/projects_assigned/'.$clientName.'/'.$subProjectName);
               // dd($request->all(),$decodedProjectName,$decodedPracticeName,$decodedClientName,$decodedsubProjectName,$modelClass);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public function assigneeChange(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $assigneeId = $request['assigneeId'];
                $decodedProjectName = Helpers::encodeAndDecodeID($request['clientName'], 'decode');
                $decodedPracticeName = Helpers::encodeAndDecodeID($request['subProjectName'], 'decode');
                $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
                $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
                $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
                $modelHistory = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'History';
                foreach($request['checkedRowValues'] as $data) {
                    $existingRecord = $modelClass::where('id',$data['value'])->first();
                    $historyRecord = $existingRecord->toArray();
                    $historyRecord['parent_id']= $historyRecord['id'];
                    unset($historyRecord['id']);
                    $modelHistory::create($historyRecord);
                    $existingRecord->update(['CE_emp_id' => $assigneeId]);
                }
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public function callerChartWorkLogs(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data =  $request->all();
                $currentTime = Carbon::now();
                $data['emp_id'] = Session::get('loginDetails')['userDetail']['emp_id'];
                $data['project_id'] = Helpers::encodeAndDecodeID($request['clientName'], 'decode');
                $data['sub_project_id'] = Helpers::encodeAndDecodeID($request['subProjectName'], 'decode');
                $data['start_time'] = $currentTime->format('Y-m-d H:i:s');
                $existingRecordId = CallerChartsWorkLogs::where('record_id',$data['record_id'])->first();

                if(empty($existingRecordId)) {
                    $startTimeVal = $data['start_time'];
                    $save_flag = CallerChartsWorkLogs::create($data);
                } else {
                    $startTimeVal = $existingRecordId->start_time;
                    $save_flag = 1;
                }

             //   dd($data);
                if($save_flag) {
                   return response()->json(['success' => true,'startTimeVal'=>$startTimeVal]);
                } else {
                    return response()->json(['success' => false]);
                }
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public function clientCompletedDatasDetails(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data =  $request->all();
                $decodedProjectName = Helpers::encodeAndDecodeID($data['clientName'], 'decode');
                $decodedPracticeName = Helpers::encodeAndDecodeID($data['subProjectName'], 'decode');
                $decodedClientName = Helpers::projectName($decodedProjectName)->project_name;
                $decodedsubProjectName = Helpers::subProjectName($decodedProjectName,$decodedPracticeName)->sub_project_name;
                $modelClassDatas = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Datas';
                $clientData = $modelClassDatas::where('parent_id',$data['record_id'])->first()->toArray();
                if(isset($clientData) && !empty($clientData)) {
                   return response()->json(['success' => true,'clientData'=>$clientData]);
                } else {
                    return response()->json(['success' => false]);
                }
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
}
