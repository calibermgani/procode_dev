<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use GuzzleHttp\Client;
use App\Models\subproject;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectWorkMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ProcodeProjectOnHoldMail;
use App\Models\CCEmailIds;
use App\Mail\ProcodeProjectFile;
class ProjectController extends Controller
{
    public function clientTableUpdate()
    {
        try {
            $payload = [
                'token' => '1a32e71a46317b9cc6feb7388238c95d',
            ];
            $client = new Client();
            $response = $client->request('POST',  config("constants.PRO_CODE_URL") . '/api/v1_users/get_project_list', [
                'json' => $payload
            ]);
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
            } else {
                return response()->json(['error' => 'API request failed'], $response->getStatusCode());
            }
            $projects = $data['project_details'];
            $subProjects = $data['practice_info'];
            $prjData = [];
            $subPrjData = [];
            foreach ($projects as $data) {
                $prjData['project_id'] = $data['id'];
                $prjData['project_name'] = $data['client_name'];
                $prjData['added_by'] = 1;
                $prjData['status'] = $data['status'];
                $prjDetails = project::where('project_id', $data['id'])->first();
                if ($prjDetails) {
                    $prjDetails->update($prjData);
                } else {
                    project::create($prjData);
                }
            }
            foreach ($subProjects as $data) {
                $subPrjData['project_id'] = $data['project_id'];
                $subPrjData['sub_project_id'] = $data['sub_project_id'];
                $subPrjData['sub_project_name'] = $data['sub_project_name'];
                $subPrjData['added_by'] = 1;
                $subPrjDetails = subproject::where('project_id', $subPrjData['project_id'])->where('sub_project_id', $subPrjData['sub_project_id'])->first();
                if ($subPrjDetails) {
                    $subPrjDetails->update($subPrjData);
                } else {
                    subproject::create($subPrjData);
                }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function projectWorkMail()
    {
        try {
            Log::info('Executing ProjectWorkMail logic.');
            $loginEmpId = Session::get('loginDetails') && Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] != null ? Session::get('loginDetails')['userDetail']['emp_id'] : "";
            $toMailId = ["elanchezhian@annexmed.net","fabian@annexmed.com","ushashree@annexmed.com"];
            $ccMailId = ["mgani@caliberfocus.com"];
            // $toMailId = ["vijayalaxmi@caliberfocus.com"];
            // $ccMailId = ["mgani@caliberfocus.com"];
                $yesterday = Carbon::yesterday();
                if ($yesterday->isSaturday()) {
                    $yesterday = $yesterday->subDay(1); // Friday
                } elseif ($yesterday->isSunday()) {
                    $yesterday = $yesterday->subDay(2); // Friday
                }
                $mailHeader = "Procode Utilization Report for ".$yesterday->format('m/d/Y');
                $yesterDayStartDate = $yesterday->startOfDay()->toDateTimeString();
                $yesterDayEndDate = $yesterday->endOfDay()->toDateTimeString();        
            // $mailHeader = "Procode Utilization Report for 06/07/2024";
            // $yesterDayStartDate = "2024-06-07 00:00:00";
            // $yesterDayEndDate = "2024-06-07 23:59:59";
            $projects = $this->getProjects();
            foreach ($projects as $project) {
                if (count($project["subprject_name"]) > 0) {
                    foreach ($project["subprject_name"] as $key => $subProject) {
                        $table_name = Str::slug((Str::lower($project["client_name"]) . '_' . Str::lower($subProject)), '_');
                        $modelName = Str::studly($table_name);
                        $modelClass = "App\\Models\\" . $modelName;
                        $models[] = $modelClass;
                        $prjoectName[] = $project["client_name"] . '-' . $subProject;
                    }
                } else {
                    $subProjectText = "project";
                    $table_name = Str::slug((Str::lower($project["client_name"]) . '_' . Str::lower($subProjectText)), '_');
                    $modelName = Str::studly($table_name);
                    $modelClass = "App\\Models\\" . $modelName;
                    $models[] = $modelClass;
                    $prjoectName[] = $project["client_name"];
                }
            }
            $assignedCounts = $coderCompleteCounts = $pendingCounts = $QACounts  = $prjoectsPending = [];
            foreach ($models as $key => $model) {
                if (class_exists($model)) {
                    $aCount = $model::whereBetween('created_at', [$yesterDayStartDate, $yesterDayEndDate])->count();
                    $cCount = $model::whereBetween('updated_at', [$yesterDayStartDate, $yesterDayEndDate])->where('chart_status', 'CE_Completed')->count();
                    $qCount = $model::whereBetween('updated_at', [$yesterDayStartDate, $yesterDayEndDate])->where('chart_status', 'QA_Completed')->count();
                    // $pCount = $aCount - $cCount;
                    $prjoectsPending[$key]['project'] = $prjoectName[$key];
                    $prjoectsPending[$key]['Chats'] = $aCount;
                    $prjoectsPending[$key]['Coder'] = $cCount;
                    $prjoectsPending[$key]['QA'] = $qCount;
                    // $prjoectsPending[$key]['Balance'] = $pCount;
                }
            }
            
            $mailBody = $prjoectsPending;
            Mail::to($toMailId)->cc($ccMailId)->send(new ProjectWorkMail($mailHeader, $mailBody, $yesterday));
            Log::info('ProjectWorkMail executed successfully.');
        } catch (\Exception $e) {
            Log::error('Error in ProjectWorkMail: ' . $e->getMessage());
            Log::debug($e->getMessage());
        }
    }

    public function getProjects()
    {
        try {
            $payload = [
                'token' => '1a32e71a46317b9cc6feb7388238c95d',
            ];
            $client = new Client();
            $response = $client->request('POST', 'https://aims.officeos.in/api/v1_users/get_all_clients', [
                'json' => $payload,
            ]);
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
            } else {
                return response()->json(['error' => 'API request failed'], $response->getStatusCode());
            }
            return $data['clientList'];
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function procodeProjectOnHoldMail()
    {
        try {
            Log::info('Executing procodeProjectOnHoldMail logic.');
            $loginEmpId = Session::get('loginDetails') && Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] != null ? Session::get('loginDetails')['userDetail']['emp_id'] : "";
            $client = new Client();
            $toMailId = ["vijayalaxmi@caliberfocus.com"];
            $ccMailId = ["mgani@caliberfocus.com"];
            $mailHeader = "Procode - Project Hold Charges reminder";
            $projects = $this->getProjects();
            foreach ($projects as $project) {
                if (count($project["subprject_name"]) > 0) {
                    foreach ($project["subprject_name"] as $key => $subProject) {
                        $table_name = Str::slug((Str::lower($project["client_name"]) . '_' . Str::lower($subProject)), '_');
                        $modelName = Str::studly($table_name);
                        $modelClass = "App\\Models\\" . $modelName;
                        $models[] = $modelClass;
                        $prjoectName[] = $project["client_name"] . '-' . $subProject;
                     $projectId[] = $project["id"]; 
                    }
                } else {
                    $subProjectText = "project";
                    $table_name = Str::slug((Str::lower($project["client_name"]) . '_' . Str::lower($subProjectText)), '_');
                    $modelName = Str::studly($table_name);
                    $modelClass = "App\\Models\\" . $modelName;
                    $models[] = $modelClass;
                    $prjoectName[] = $project["client_name"];
                    $projectId[] = $project["id"]; 
                }
            }
            $prjoectsHolding = $projectsIds = [];
            foreach ($models as $key => $model) {
                if (class_exists($model)) {
                     $hCount = $model::where('chart_status', 'CE_Hold')->count();
                        if($hCount > 0){
                            $prjoectsHolding[$projectId[$key]]['project'] = $prjoectName[$key];
                            $prjoectsHolding[$projectId[$key]]['Hold'] = $hCount;
                            // $prjoectsHolding[$key]['project_id'] = $projectId[$key];
                            $projectsIds[] = $projectId[$key];  
                        }
                }
            }
            $payload = [
                'token' => '1a32e71a46317b9cc6feb7388238c95d',
                'client_id' => $projectsIds
            ];
            //  $response = $client->request('POST',  config("constants.PRO_CODE_URL") . '/api/v1_users/get_details_above_tl_level', [
              $response = $client->request('POST', 'https://aims.officeos.in/api/v1_users/get_details_above_tl_level', [
                'json' => $payload
            ]);
            if ($response->getStatusCode() == 200) {
                $apiData = json_decode($response->getBody(), true);
            } else {
                return response()->json(['error' => 'API request failed'], $response->getStatusCode());
            }
            $projectsHolding = $apiData['people_details'];dd($prjoectsHolding);
            foreach($projectsHolding as $data) {
                $clientIds = $data['client_ids'];
                $mailBody = $prjoectsHolding;
                if($data["email_id"] != null) {
                    // $toMailId = $data["email_id"];
                    // $ccMail = CCEmailIds::select('cc_emails')->where('cc_module','project hold records')->first();
                    // $ccMailId = explode(",",$ccMail->cc_emails);
                    Mail::to($toMailId)->cc($ccMailId)->send(new ProcodeProjectOnHoldMail($mailHeader, $clientIds, $mailBody));
                    Log::info('Procode Project On Hold Mail executed successfully.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in ProjectOnHoldMail: ' . $e->getMessage());
            Log::debug($e->getMessage());
        }
    }

    public function projectFileNotInFolder(Request $request)
    {
                $project_information = $request->all();
                $current_time = Carbon::now();
                if ($current_time->hour >= 11) {
                    $fileStatus = "The " .$project_information['project_name']." inventory is not in the specified location. Could you please check and place the inventory files for today as soon as possible. This will help avoid delays in production.";
                    $mailHeader = $project_information['project_name']." File not in Specific folder";
                    $toMailId = ["mgani@caliberfocus.com"];
                    Mail::to($toMailId)->send(new ProcodeProjectFile($mailHeader, $fileStatus));
                    Log::info('ProjectFileNotThere executed successfully.');
                    return response()->json([
                        "message" => "file is not there"
                        ]);
                }
               
             
    }
}
