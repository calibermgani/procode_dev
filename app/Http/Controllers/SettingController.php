<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Models\QualitySampling;
use App\Models\QualitySamplingHistory;
use Illuminate\Support\Str;
use App\Http\Helper\Admin\Helpers as Helpers;

class SettingController extends Controller
{
    public function qualitySampling(Request $request) {
            if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
                try {
                    $payload = [
                        'token' => '1a32e71a46317b9cc6feb7388238c95d'
                    ];
                    $client = new Client();
                    $response = $client->request('POST', 'https://aims.officeos.in/api/v1_users/get_coder_emp_list', [
                        'json' => $payload
                    ]);
                    if ($response->getStatusCode() == 200) {
                        $data = json_decode($response->getBody(), true);
                    } else {
                        return response()->json(['error' => 'API request failed'], $response->getStatusCode());
                    }
                    $coderList = $data['coderList'];

                    $qaResponse = $client->request('POST', 'https://aims.officeos.in/api/v1_users/get_qa_emp_list', [
                        'json' => $payload
                    ]);
                    if ($qaResponse->getStatusCode() == 200) {
                        $qaData = json_decode($qaResponse->getBody(), true);
                    } else {
                        return response()->json(['error' => 'API request failed'], $qaResponse->getStatusCode());
                    }

                    $qaList = $qaData['qaList'];
                    $qaSamplingList = QualitySampling::orderBy('id','desc')->get()->toArray();

                    return view('settings/qualitySampling',compact('coderList','qaList','qaSamplingList'));
                } catch (Exception $e) {
                    log::debug($e->getMessage());
                }
        } else {
                return redirect('/');
        }
    }
    public function qualitySamplingStore(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data =  $request->all();
                $data['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];
                 QualitySampling::create($data);
                return redirect('/sampling' . '?parent=' . request()->parent . '&child=' . request()->child);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/');
        }
    }

    public function qualitySamplingUpdate(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data =  $request->all();
                $data['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];
                $existingRecord = QualitySampling::where('id',$data["record_id"])->first();
                if($existingRecord) {//dd($data,$existingRecord);//need to maintain history
                    $historyRecord = $existingRecord->toArray();
                    $historyRecord['quality_sampling_id']= $historyRecord['id'];
                    unset($historyRecord['id']);
                    QualitySamplingHistory::create($historyRecord);
                    $existingRecord->update($data);
                } else {
                   QualitySampling::create($data);
                }
                return redirect('/sampling' . '?parent=' . request()->parent . '&child=' . request()->child);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/');
        }
    }
}
