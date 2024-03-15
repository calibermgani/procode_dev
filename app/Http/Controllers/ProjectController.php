<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use GuzzleHttp\Client;
use App\Models\subproject;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    public function clientTableUpdate() {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $userId = Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['id'] !=null ? Session::get('loginDetails')['userDetail']['id']:"";
                $payload = [
                    'token' => '1a32e71a46317b9cc6feb7388238c95d',
                ];
                $client = new Client();
                $response = $client->request('POST', 'http://dev.aims.officeos.in/api/v1_users/get_project_list', [
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
                foreach( $projects as $data) {
                    $prjData['project_id'] = $data['id'];
                    $prjData['project_name'] = $data['client_name'];
                    $prjData['added_by'] = $userId;
                    $prjData['status'] = $data['status'];
                    $prjDetails = project::where('project_id',$data['id'])->first();
                    if($prjDetails) {
                        $prjDetails->update($prjData);
                    } else {
                        project::create($prjData);
                    }
                }
                foreach($subProjects as $data) {
                    $subPrjData['project_id'] = $data['project_id'];
                    $subPrjData['sub_project_id'] = $data['sub_project_id'];
                    $subPrjData['sub_project_name'] = $data['sub_project_name'];
                    $subPrjData['added_by'] = $userId;
                    $subPrjDetails = subproject::where('project_id',$subPrjData['project_id'])->where('sub_project_id',$subPrjData['sub_project_id'] )->first();
                    if($subPrjDetails) {
                        $subPrjDetails->update($subPrjData);
                    } else {
                        subproject::create($subPrjData);
                    }
                }

            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
        return redirect('/login');
        }
    }
}
