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
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $decodedsubProjectName = Helpers::encodeAndDecodeID($subProjectName, 'decode');
                $modelClass = "App\\Models\\" . 'Inventory'.ucfirst($decodedsubProjectName);
                 $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($loginEmpId && $empDesignation == "Administrator") {
                    $assignedProjectDetails = InventoryWound::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                    //$assignedProjectDetails = $modelClass::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                    $assignedProjectDetails = InventoryWound::select('ticket_number','patient_name','patient_id','dob','dos','coders_em_icd_10','em_dx')->where('status','CE_Inprocess')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                }
                return view('productions/clientAssignedTab',compact('assignedProjectDetails','databaseConnection'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientPendingTab($clientName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($loginEmpId && $empDesignation == "Administrator") {
                    $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                    $pendingProjectDetails = InventoryWound::where('status','CE_Pending')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                }

                return view('productions/clientPendingTab',compact('pendingProjectDetails','databaseConnection'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientHoldTab($clientName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($loginEmpId && $empDesignation == "Administrator") {
                    $holdProjectDetails = InventoryWound::where('status','CE_Hold')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                $holdProjectDetails = InventoryWound::where('status','CE_Hold')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                }

                return view('productions/clientOnholdTab',compact('databaseConnection','holdProjectDetails'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientCompletedTab($clientName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($loginEmpId && $empDesignation == "Administrator") {
                    $completedProjectDetails = InventoryWound::where('status','CE_Completed')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                    $completedProjectDetails = InventoryWound::where('status','CE_Completed')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                }
                return view('productions/clientCompletedTab',compact('databaseConnection','completedProjectDetails'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientReworkTab($clientName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($loginEmpId && $empDesignation == "Administrator") {
                    $completedProjectDetails = InventoryWound::where('status','CE_Completed')->orderBy('id','desc')->get();
                } elseif ($loginEmpId) {
                $completedProjectDetails = InventoryWound::where('status','CE_Completed')->where('CE_emp_id',$loginEmpId)->orderBy('id','desc')->get();
                }

                return view('productions/clientReworkTab',compact('databaseConnection','completedProjectDetails'));

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function clientDuplicateTab($clientName) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {

            try {
                $loginEmpId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null ? Session::get('loginDetails')['userDetail']['emp_id']:"";
                $empDesignation = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] &&  Session::get('loginDetails')['userDetail']['designation'] && Session::get('loginDetails')['userDetail']['designation']['designation'] !=null ? Session::get('loginDetails')['userDetail']['designation']['designation'] : "";
                $decodedClientName = Helpers::encodeAndDecodeID($clientName, 'decode');
                $databaseConnection = Str::lower($decodedClientName);
                Config::set('database.connections.mysql.database',$databaseConnection);

                if ($empDesignation == "Administrator") {
                    $duplicateProjectDetails = InventoryWoundDuplicate::whereNotIn('status',['agree','dis_agree'])->orderBy('id','desc')->get();
                } else {
                    $duplicateProjectDetails = [];
                }
                return view('productions/clientDuplicateTab',compact('databaseConnection','duplicateProjectDetails'));
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
}
