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
            $subprojects = subproject::with(['clientName'])->where('project_id',$request->project_id)->where('status','Active')->get();
            return response()->json(['subprojects' => $subprojects]);
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
                $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
                $columnsToExclude = ['updated_at','created_at', 'deleted_at'];
                $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                    return !in_array($column, $columnsToExclude);
                });
                $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
                $modelClassDatas = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName).'Datas';
                $assignedProjectDetails = collect();
                if ($loginEmpId && $empDesignation == "Administrator") {
                    // if (Schema::hasTable($table_name)) {
                    //    $assignedProjectDetails = DB::table($table_name)->get();
                    // }
                    if (class_exists($modelClassDatas) && class_exists($modelClass)) {
                        // $assignedProjectDetails = $modelClassDatas::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                        // if(count($assignedProjectDetails) == 0) {
                        //     $assignedProjectDetails = $modelClass::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                        // }
                        $assignedProjectDetails = $modelClass::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                    }

                    $popUpHeader =  formConfiguration::groupBy(['project_id', 'sub_project_id'])
                    ->where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)
                    ->select('project_id', 'sub_project_id')
                    ->first();
                    $popupNonEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->where('field_type','non_editable')->where('field_type_3','popup_visible')->get();
                    $popupEditableFields = formConfiguration::where('project_id',$decodedProjectName)->where('sub_project_id',$decodedPracticeName)->where('field_type','editable')->where('field_type_3','popup_visible')->get();
                    // $assignedProjectDetails = InventoryWound::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                    //$assignedProjectDetails = $modelClass::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                   if (class_exists($modelClass)) {
                       $assignedProjectDetails = $modelClass::where('claim_status','CE_Assigned')->orderBy('id','desc')->get();
                    }
                }
                    return view('productions/clientAssignedTab',compact('assignedProjectDetails','columnsHeader','popUpHeader','popupNonEditableFields','popupEditableFields','modelClass','clientName','subProjectName'));

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
               $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
               $columnsToExclude = ['id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $pendingProjectDetails = $modelClass::where('claim_status','CE_Pending')->orderBy('id','desc')->get();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $pendingProjectDetails = $modelClass::where('claim_status','CE_Pending')->orderBy('id','desc')->get();
                   }
                 }
                return view('productions/clientPendingTab',compact('pendingProjectDetails','columnsHeader','clientName','subProjectName','modelClass'));

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
               $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
               $columnsToExclude = ['id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $holdProjectDetails = $modelClass::where('claim_status','CE_Hold')->orderBy('id','desc')->get();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $holdProjectDetails = $modelClass::where('claim_status','CE_Hold')->orderBy('id','desc')->get();
                   }
                 }
                return view('productions/clientOnholdTab',compact('holdProjectDetails','columnsHeader','clientName','subProjectName','modelClass'));

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
               $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
               $columnsToExclude = ['id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $completedProjectDetails = $modelClass::where('claim_status','CE_Completed')->orderBy('id','desc')->get();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $completedProjectDetails = $modelClass::where('claim_status','CE_Completed')->orderBy('id','desc')->get();
                   }
                 }
                return view('productions/clientCompletedTab',compact('completedProjectDetails','columnsHeader','clientName','subProjectName','modelClass'));

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
               $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
               $columnsToExclude = ['id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName);
               $pendingProjectDetails = collect();
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                       $revokeProjectDetails = $modelClass::where('claim_status','Revoke')->orderBy('id','desc')->get();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      $revokeProjectDetails = $modelClass::where('claim_status','Revoke')->orderBy('id','desc')->get();
                   }
                 }
                return view('productions/clientReworkTab',compact('revokeProjectDetails','columnsHeader','clientName','subProjectName','modelClass'));

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
               $columns = DB::getSchemaBuilder()->getColumnListing($table_name);
               $columnsToExclude = ['id','updated_at','created_at', 'deleted_at'];
               $columnsHeader = array_filter($columns, function ($column) use ($columnsToExclude) {
                   return !in_array($column, $columnsToExclude);
               });
               $modelClass = "App\\Models\\" . ucfirst($decodedClientName).ucfirst($decodedsubProjectName)."_Duplicates";
               $duplicateProjectDetails = collect();
               if ($loginEmpId && $empDesignation == "Administrator") {
                   if (class_exists($modelClass)) {
                        //   $duplicateProjectDetails =  $modelClass::whereNotIn('status',['agree','dis_agree'])->orderBy('id','desc')->get();
                        $duplicateProjectDetails =  $modelClass::orderBy('id','desc')->get();
                   }
                } else if ($loginEmpId) {
                    if (class_exists($modelClass)) {
                      // $duplicateProjectDetails = [];
                   }
                 }
                return view('productions/clientDuplicateTab',compact('duplicateProjectDetails','columnsHeader','clientName','subProjectName','modelClass'));

           } catch (Exception $e) {
               log::debug($e->getMessage());
           }
       } else {
           return redirect('/login');
       }
    }
    // public function clientPendingTab($clientName) {
    //     if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

    //         try {
    //             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
    //             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
    //             $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
    //             $databaseConnection = Str::lower($decodedClientName);
    //             Config::set('database.connections.mysql.database',$databaseConnection);

    //             if ($loginEmpId && $empDesignation == "Administrator") {
    //                 $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->orderBy('id','desc')->get();
    //             } elseif ($loginEmpId) {
    //                 $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
    //             }

    //             return view('productions/clientPendingTab',compact('pendingProjectDetails','databaseConnection'));

    //         } catch (Exception $e) {
    //             log::debug($e->getMessage());
    //         }
    //     } else {
    //         return redirect('/login');
    //     }
    // }
    // public function clientHoldTab($clientName) {
    //     if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

    //         try {
    //             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
    //             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
    //             $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
    //             $databaseConnection = Str::lower($decodedClientName);
    //             Config::set('database.connections.mysql.database',$databaseConnection);

    //             if ($loginEmpId && $empDesignation == "Administrator") {
    //                 $holdProjectDetails = InventoryWound::where('status','CE_Hold')->orderBy('id','desc')->get();
    //             } elseif ($loginEmpId) {
    //             $holdProjectDetails = InventoryWound::where('status','CE_Hold')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
    //             }

    //             return view('productions/clientOnholdTab',compact('databaseConnection','holdProjectDetails'));

    //         } catch (Exception $e) {
    //             log::debug($e->getMessage());
    //         }
    //     } else {
    //         return redirect('/login');
    //     }
    // }
    // public function clientCompletedTab($clientName) {
    //     if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

    //         try {
    //             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
    //             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
    //             $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
    //             $databaseConnection = Str::lower($decodedClientName);
    //             Config::set('database.connections.mysql.database',$databaseConnection);

    //             if ($loginEmpId && $empDesignation == "Administrator") {
    //                 $completedProjectDetails = InventoryWound::where('status','CE_Completed')->orderBy('id','desc')->get();
    //             } elseif ($loginEmpId) {
    //                 $completedProjectDetails = InventoryWound::where('status','CE_Completed')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
    //             }
    //             return view('productions/clientCompletedTab',compact('databaseConnection','completedProjectDetails'));

    //         } catch (Exception $e) {
    //             log::debug($e->getMessage());
    //         }
    //     } else {
    //         return redirect('/login');
    //     }
    // }
    // public function clientReworkTab($clientName) {
    //     if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

    //         try {
    //             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
    //             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
    //             $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
    //             $databaseConnection = Str::lower($decodedClientName);
    //             Config::set('database.connections.mysql.database',$databaseConnection);

    //             if ($loginEmpId && $empDesignation == "Administrator") {
    //                 $completedProjectDetails = InventoryWound::where('status','CE_Completed')->orderBy('id','desc')->get();
    //             } elseif ($loginEmpId) {
    //             $completedProjectDetails = InventoryWound::where('status','CE_Completed')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
    //             }

    //             return view('productions/clientReworkTab',compact('databaseConnection','completedProjectDetails'));

    //         } catch (Exception $e) {
    //             log::debug($e->getMessage());
    //         }
    //     } else {
    //         return redirect('/login');
    //     }
    // }
    // public function clientDuplicateTab($clientName) {
    //     if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

    //         try {
    //             $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
    //             $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
    //             $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
    //             $databaseConnection = Str::lower($decodedClientName);
    //             Config::set('database.connections.mysql.database',$databaseConnection);

    //             if ($empDesignation == "Administrator") {
    //                 $duplicateProjectDetails = InventoryWoundDuplicate::whereNotIn('status',['agree','dis_agree'])->orderBy('id','desc')->get();
    //             } else {
    //                 $duplicateProjectDetails = [];
    //             }
    //             return view('productions/clientDuplicateTab',compact('databaseConnection','duplicateProjectDetails'));
    //         } catch (Exception $e) {
    //             log::debug($e->getMessage());
    //         }
    //     } else {
    //         return redirect('/login');
    //     }
    // }
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
                dd($request->all(),$decodedProjectName,$decodedPracticeName,$decodedClientName,$decodedsubProjectName,$modelClass);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
}
