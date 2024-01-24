<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subProject;
use App\Models\project;
use App\Models\formConfiguration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\Admin\Helpers as Helpers;

class FormController extends Controller
{
    public function formConfigurationList() {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                //  $formConfiguration = formConfiguration::select('project_name', 'sub_project_name')
                //             ->groupBy(['project_name', 'sub_project_name'])
                //             ->get();

                            $formConfiguration = formConfiguration::groupBy(['project_name', 'sub_project_name'])
    ->select('project_name', 'sub_project_name', DB::raw('GROUP_CONCAT(label_name) as label_names'))
    ->get();

               return view('Form.formConfigList',compact('formConfiguration'));
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function formCreationIndex() {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
               return view('Form.formIndex');
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public static function getSubProjectList(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $data = subProject::where('project_id', $request->project_id)->where('status', 'Active')->pluck('sub_project_name', 'id')->prepend(trans('Select'), '')->toArray();
                return response()->json($data);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public static function formConfigurationStore(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userInfo'] && Session::get('loginDetails')['userInfo']['user_id'] !=null) {
            try {
                $data = $request->all();
                $projectName = project::where('id',$data['project_id'])->first();
                $subProjectName = subProject::where('project_id',$data['project_id'])->where('id',$data['sub_project_id'])->first();
                $columns = [];
                for($i=0;$i<count($data['label_name']);$i++) {
                    $requiredData['project_name'] = $projectName->project_name;
                    $requiredData['sub_project_name'] = $subProjectName->sub_project_name;
                    $requiredData['label_name'] = $data['label_name'][$i];
                    $requiredData['input_type'] = $data['input_type'][$i];
                    $requiredData['options_name'] = $data['options_name'][$i];
                    $requiredData['field_type'] = $data['field_type'][$i];
                    $requiredData['field_type_1'] = $data['field_type_1'][$i];
                    $requiredData['field_type_2'] = $data['field_type_2'][$i];
                    $requiredData['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];
                    formConfiguration::create($requiredData);
                    $columnName = str_replace([' ', '/'], '_', $data['label_name'][$i]);
                    $columns[$columnName] =  'VARCHAR(255)';
                }
                $tableName =$projectName->project_name.'_'.$subProjectName->sub_project_name;
                $tableExists = DB::select("SHOW TABLES LIKE '$tableName'");


                    if (empty($tableExists)) {
                        $createTableSQL = "CREATE TABLE $tableName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName $columnType";
                        }

                        $createTableSQL .= ", created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                    } else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$tableName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {
                                DB::statement("ALTER TABLE $tableName ADD COLUMN $columnName $columnType AFTER $afterColumn");
                            }
                        }
                    }
               dd($data);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function formEdit($project_name,$sub_project_name) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $projectName = Helpers::encodeAndDecodeID($project_name,'decode');
                $subProjectName = Helpers::encodeAndDecodeID($sub_project_name,'decode');
                $projectDetails = formConfiguration::groupBy(['project_name', 'sub_project_name'])
                ->where('project_name',$projectName)->where('sub_project_name',$subProjectName)
                ->select('project_name', 'sub_project_name')
                ->first();
                $formDetails = formConfiguration::where('project_name',$projectName)->where('sub_project_name',$subProjectName)
                ->get();
               return view('Form.formEdit',compact('projectDetails','formDetails'));
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
}
