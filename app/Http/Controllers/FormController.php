<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subProject;
use App\Models\project;
use App\Models\formConfiguration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\Admin\Helpers as Helpers;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function formConfigurationList() {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                    $formConfiguration = formConfiguration::groupBy(['project_id', 'sub_project_id'])
                                            ->select('project_id', 'sub_project_id', DB::raw('GROUP_CONCAT(label_name) as label_names'))
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
                $existingSubProject = formConfiguration::where('project_id', $request->project_id)->groupBy(['project_id', 'sub_project_id'])
                ->pluck('sub_project_id')->toArray();
                $data = subProject::where('project_id', $request->project_id)->where('status', 'Active')->pluck('sub_project_name', 'id')->prepend(trans('Select'), '')->toArray();
                return response()->json(["subProject" => $data, "existingSubProject" => $existingSubProject]);
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
                $data = $request->all();//dd($data);
                $projectName = project::where('id',$data['project_id'])->first();
                $subProjectName = subProject::where('project_id',$data['project_id'])->where('id',$data['sub_project_id'])->first();
                $columns = [];
                for($i=0;$i<count($data['label_name']);$i++) {
                    $requiredData['project_id'] = $data['project_id'];
                    $requiredData['sub_project_id'] = $data['sub_project_id'];
                    $requiredData['label_name'] = $data['label_name'][$i];
                    $requiredData['input_type'] = $data['input_type'][$i];
                    $requiredData['options_name'] = $data['options_name'][$i];
                    $requiredData['field_type'] = $data['field_type'][$i];
                    $requiredData['field_type_1'] = $data['field_type_1'][$i];
                    $requiredData['field_type_2'] = $data['field_type_2'][$i];
                    $requiredData['field_type_3'] = $data['field_type_3'][$i];
                    $requiredData['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];
                    formConfiguration::create($requiredData);
                    $columnName = Str::lower(str_replace([' ', '/'], '_', $data['label_name'][$i]));
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
                    return redirect('/form_configuration_list' . '?parent=' . request()->parent . '&child=' . request()->child);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
    public function formEdit($project_id,$sub_project_id) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userDetail'] && Session::get('loginDetails')['userDetail']['emp_id'] !=null) {
            try {
                $projectId = Helpers::encodeAndDecodeID($project_id,'decode');
                $subProjectId = Helpers::encodeAndDecodeID($sub_project_id,'decode');
                $projectDetails = formConfiguration::groupBy(['project_id', 'sub_project_id'])
                ->where('project_id',$projectId)->where('sub_project_id',$subProjectId)
                ->select('project_id', 'sub_project_id')
                ->first();
                $formDetails = formConfiguration::where('project_id',$projectId)->where('sub_project_id',$subProjectId)
                ->get();
               return view('Form.formEdit',compact('projectDetails','formDetails'));
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }

    public static function formConfigurationUpdate(Request $request) {
        if (Session::get('loginDetails') &&  Session::get('loginDetails')['userInfo'] && Session::get('loginDetails')['userInfo']['user_id'] !=null) {
            try {
                $data = $request->all();//dd($data);
                $projectName = project::where('id',$data['project_id_val'])->first();
                $subProjectName = subProject::where('project_id',$data['project_id_val'])->where('id',$data['sub_project_id_val'])->first();
                $columns = [];
                for($i=0;$i<count($data['label_name']);$i++) {
                    $existingRecord = formConfiguration::where('label_name',$data['label_name'][$i])->first();//dd($existingRecord);
                    if($existingRecord)
                    {
                        $requiredData['project_id'] = $data['project_id_val'];
                        $requiredData['sub_project_id'] = $data['sub_project_id_val'];
                        $requiredData['label_name'] = $data['label_name'][$i];
                        //$requiredData['input_type'] = $data['input_type'][$i];
                        $requiredData['options_name'] = $data['options_name'][$i];
                        $requiredData['field_type'] = $data['field_type'][$i];
                        $requiredData['field_type_1'] = $data['field_type_1'][$i];
                        $requiredData['field_type_2'] = $data['field_type_2'][$i];
                        $requiredData['field_type_3'] = $data['field_type_3'][$i];
                        $requiredData['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];//dd($existingRecord,$requiredData);
                        $existingRecord->update($requiredData);
                    } else {
                        $requiredData['project_id'] = $data['project_id_val'];
                        $requiredData['sub_project_id'] = $data['sub_project_id_val'];
                        $requiredData['label_name'] = $data['label_name'][$i];
                        $requiredData['input_type'] = $data['input_type'][$i];
                        $requiredData['options_name'] = $data['options_name'][$i];
                        $requiredData['field_type'] = $data['field_type'][$i];
                        $requiredData['field_type_1'] = $data['field_type_1'][$i];
                        $requiredData['field_type_2'] = $data['field_type_2'][$i];
                        $requiredData['field_type_3'] = $data['field_type_3'][$i];
                        $requiredData['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];
                        formConfiguration::create($requiredData);
                        $columnName = Str::lower(str_replace([' ', '/'], '_', $data['label_name'][$i]));
                        $columns[$columnName] =  'VARCHAR(255)';
                    }
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
                    return redirect('/form_configuration_list' . '?parent=' . request()->parent . '&child=' . request()->child);
            } catch (Exception $e) {
                log::debug($e->getMessage());
            }
        } else {
            return redirect('/login');
        }
    }
}
