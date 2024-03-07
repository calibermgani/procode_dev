<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subproject;
use App\Models\project;
use App\Models\formConfiguration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\Admin\Helpers as Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use App\Models\DynamicModel;

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
                $data = $request->all();dd($data);
                $projectName = project::where('id',$data['project_id'])->first();
                $subProjectName = subproject::where('project_id',$data['project_id'])->where('id',$data['sub_project_id'])->first();
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
                    $requiredData['user_type'] = $data['user_type'][$i];
                    formConfiguration::create($requiredData);
                    // $columnName = Str::lower(str_replace([' ', '/'], ['_'], $data['label_name'][$i]));
                    $columnName = Str::lower(str_replace([' ', '/'], ['_', '_else_'], $data['label_name'][$i]));
                    if ($data['input_type'][$i] == 'text' || $data['input_type'][$i] == 'textarea' || $data['input_type'][$i] == 'date_range') {
                        $columns[$columnName] = 'VARCHAR(255)';
                    } else if ($data['input_type'][$i] == 'select' || $data['input_type'][$i] == 'checkbox' || $data['input_type'][$i] == 'radio') {
                        $enumValues = "'" . implode("','", explode(',',$data['options_name'][$i])) . "'";
                        $columns[$columnName] = "ENUM($enumValues)";
                    } else if ($data['input_type'][$i] == 'date') {
                        $columns[$columnName] = 'DATE';
                    }
                }
                $tableName =$projectName->project_name.'_'.$subProjectName->sub_project_name;
                $tableDataName =$projectName->project_name.'_'.$subProjectName->sub_project_name. '_datas';
                $duplicateTableName = $projectName->project_name . '_' . $subProjectName->sub_project_name . '_duplicates';
                $tableHistoryName =$projectName->project_name.'_'.$subProjectName->sub_project_name. '_history';
                $tableExists = DB::select("SHOW TABLES LIKE '$tableName'");
                    if (empty($tableExists)) {
                        $createTableSQL = "CREATE TABLE $tableName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName $columnType";
                        }

                        $createTableSQL .= ", invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableName);
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
                                $dynamicModel = new DynamicModel($tableName);
                                $dynamicModel->refreshFillableFromTable();
                            }
                        }
                    }
                    $duplicateTableExists = DB::select("SHOW TABLES LIKE '$duplicateTableName'");

                    if (empty($duplicateTableExists)) {
                        $createDuplicateTableSQL = "CREATE TABLE $duplicateTableName (id INT AUTO_INCREMENT PRIMARY KEY";

                        foreach ($columns as $columnName => $columnType) {
                            $createDuplicateTableSQL .= ", $columnName $columnType";
                        }

                        $createDuplicateTableSQL .= ", invoke_date DATE NULL,
                                                    CE_emp_id VARCHAR(255) NULL,
                                                    QA_emp_id VARCHAR(255) NULL,
                                                    claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                    deleted_at TIMESTAMP NULL)";
                        DB::statement($createDuplicateTableSQL);
                        $dynamicDuplicateModel = new DynamicModel($duplicateTableName);
                    }  else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$duplicateTableName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {

                                DB::statement("ALTER TABLE $duplicateTableName ADD COLUMN $columnName $columnType AFTER $afterColumn");
                                $dynamicDuplicateModel = new DynamicModel($duplicateTableName);
                                $dynamicDuplicateModel->refreshFillableFromTable();
                            }
                        }
                    }

                    $tableDatasExists = DB::select("SHOW TABLES LIKE '$tableDataName'");
                    if (empty($tableDatasExists)) {
                        $createTableSQL = "CREATE TABLE $tableDataName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName VARCHAR(255)";
                        }

                        $createTableSQL .= ", parent_id INT NULL,invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableDataName);
                    } else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$tableDataName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {

                                DB::statement("ALTER TABLE $tableDataName ADD COLUMN $columnName VARCHAR(255) AFTER $afterColumn");
                                $dynamicModel = new DynamicModel($tableDataName);
                                $dynamicModel->refreshFillableFromTable();
                            }
                        }
                    }

                    $tableHistoryExists = DB::select("SHOW TABLES LIKE '$tableHistoryName'");
                    if (empty($tableHistoryExists)) {
                        $createTableSQL = "CREATE TABLE $tableHistoryName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName VARCHAR(255)";
                        }

                        $createTableSQL .= ", parent_id INT NULL,invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableHistoryName);
                    } else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$tableHistoryName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {

                                DB::statement("ALTER TABLE $tableHistoryName ADD COLUMN $columnName VARCHAR(255) AFTER $afterColumn");
                                $dynamicModel = new DynamicModel($tableHistoryName);
                                $dynamicModel->refreshFillableFromTable();
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
                $data = $request->all();dd($data);
                $projectName = project::where('id',$data['project_id_val'])->first();
                $subProjectName = subproject::where('project_id',$data['project_id_val'])->where('id',$data['sub_project_id_val'])->first();
                $columns = [];
                for($i=0;$i<count($data['label_name']);$i++) {
                    $existingRecord = formConfiguration::where('label_name',$data['label_name'][$i])->first();dd($existingRecord);
                    if($existingRecord)
                    {
                        $requiredData['project_id'] = $data['project_id_val'];
                        $requiredData['sub_project_id'] = $data['sub_project_id_val'];
                        $requiredData['label_name'] = $data['label_name'][$i];
                        $requiredData['options_name'] = $data['options_name'][$i];
                        $requiredData['field_type'] = $data['field_type'][$i];
                        $requiredData['field_type_1'] = $data['field_type_1'][$i];
                        $requiredData['field_type_2'] = $data['field_type_2'][$i];
                        $requiredData['field_type_3'] = $data['field_type_3'][$i];
                        $requiredData['added_by'] = Session::get('loginDetails')['userInfo']['user_id'];//dd($existingRecord,$requiredData);
                        $requiredData['user_type'] = $data['user_type'][$i];
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
                        $requiredData['user_type'] = $data['user_type'][$i];
                        formConfiguration::create($requiredData);
                       // $columnName = Str::lower(str_replace([' ', '/'], '_', $data['label_name'][$i]));
                        $columnName = Str::lower(str_replace([' ', '/'], ['_', '_else_'], $data['label_name'][$i]));
                        if ($data['input_type'][$i] == 'text' || $data['input_type'][$i] == 'textarea' || $data['input_type'][$i] == 'date_range') {
                            $columns[$columnName] = 'VARCHAR(255)';
                        } else if ($data['input_type'][$i] == 'select' || $data['input_type'][$i] == 'checkbox' || $data['input_type'][$i] == 'radio') {
                              $enumValues = "'" . implode("','", explode(',',$data['options_name'][$i])) . "'";
                            $columns[$columnName] = "ENUM($enumValues)";
                        } else if ($data['input_type'][$i] == 'date') {
                            $columns[$columnName] = 'DATE';
                        }
                    }

                }
                $tableName =$projectName->project_name.'_'.$subProjectName->sub_project_name;
                $tableDataName =$projectName->project_name.'_'.$subProjectName->sub_project_name. '_datas';
                $duplicateTableName = $projectName->project_name . '_' . $subProjectName->sub_project_name . '_duplicates';
                $tableHistoryName =$projectName->project_name.'_'.$subProjectName->sub_project_name. '_history';

                $tableExists = DB::select("SHOW TABLES LIKE '$tableName'");
                    if (empty($tableExists)) {
                        $createTableSQL = "CREATE TABLE $tableName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName $columnType";
                        }

                        $createTableSQL .= ", parent_id INT NULL,invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableName);
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
                                $dynamicModel = new DynamicModel($tableName);
                                $dynamicModel->refreshFillableFromTable();
                            }
                        }
                    }
                    $duplicateTableExists = DB::select("SHOW TABLES LIKE '$duplicateTableName'");

                    if (empty($duplicateTableExists)) {
                        $createDuplicateTableSQL = "CREATE TABLE $duplicateTableName (id INT AUTO_INCREMENT PRIMARY KEY";

                        foreach ($columns as $columnName => $columnType) {
                            $createDuplicateTableSQL .= ", $columnName $columnType";
                        }

                        $createDuplicateTableSQL .= ", invoke_date DATE NULL,
                                                    CE_emp_id VARCHAR(255) NULL,
                                                    QA_emp_id VARCHAR(255) NULL,
                                                    claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                    deleted_at TIMESTAMP NULL)";
                        DB::statement($createDuplicateTableSQL);
                        $dynamicDuplicateModel = new DynamicModel($duplicateTableName);
                    }  else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$duplicateTableName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {
                                DB::statement("ALTER TABLE $duplicateTableName ADD COLUMN $columnName $columnType AFTER $afterColumn");
                                $dynamicDuplicateModel = new DynamicModel($duplicateTableName);
                                $dynamicDuplicateModel->refreshFillableFromTable();
                            }
                        }
                    }

                    $tableDatasExists = DB::select("SHOW TABLES LIKE '$tableDataName'");
                    if (empty($tableDatasExists)) {
                        $createTableSQL = "CREATE TABLE $tableDataName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName VARCHAR(255)";
                        }

                        $createTableSQL .= ", parent_id INT NULL,invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableDataName);
                    } else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$tableDataName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {

                                DB::statement("ALTER TABLE $tableDataName ADD COLUMN $columnName VARCHAR(255) AFTER $afterColumn");
                                $dynamicModel = new DynamicModel($tableDataName);
                                $dynamicModel->refreshFillableFromTable();
                            }
                        }
                    }

                    $tableHistoryExists = DB::select("SHOW TABLES LIKE '$tableHistoryName'");
                    if (empty($tableHistoryExists)) {
                        $createTableSQL = "CREATE TABLE $tableHistoryName (id INT AUTO_INCREMENT PRIMARY KEY";
                        foreach ($columns as $columnName => $columnType) {
                            $createTableSQL .= ", $columnName VARCHAR(255)";
                        }

                        $createTableSQL .= ", parent_id INT NULL,invoke_date DATE NULL,
                                            CE_emp_id VARCHAR(255) NULL,
                                            QA_emp_id VARCHAR(255) NULL,
                                            claim_status ENUM('CE_Assigned','CE_Inprocess','CE_Pending','CE_Completed','CE_Clarification','CE_Hold','QA_Assigned','QA_Inprocess','QA_Pending','QA_Completed','QA_Clarification','QA_Hold','Revoke') DEFAULT 'CE_Assigned',
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            deleted_at TIMESTAMP NULL)";
                        DB::statement($createTableSQL);
                        $dynamicModel = new DynamicModel($tableHistoryName);
                    } else {
                        $afterColumn = 'created_at';
                        foreach ($columns as $columnName => $columnType) {
                            $columnExists = DB::select("
                                SELECT COLUMN_NAME
                                FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = '$tableHistoryName'
                                AND COLUMN_NAME = '$columnName'
                            ");
                            if (empty($columnExists)) {

                                DB::statement("ALTER TABLE $tableHistoryName ADD COLUMN $columnName VARCHAR(255) AFTER $afterColumn");
                                $dynamicModel = new DynamicModel($tableHistoryName);
                                $dynamicModel->refreshFillableFromTable();
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
