<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1_projects'], function() {
    Route::post('prjoect_details', 'App\Http\Controllers\AIGController@projectDetails');
    Route::any('file_not_in_folder', 'App\Http\Controllers\AIGController@fileNotInFolder')->name('fileNotInFolder');
    Route::any('empty_reocrd_mail', 'App\Http\Controllers\AIGController@emptyRecordMail')->name('emptyRecordMail');
    Route::any('duplicate_entry_mail', 'App\Http\Controllers\AIGController@duplicateEntryMail')->name('duplicateEntryMail');
    Route::any('file_format_not_match', 'App\Http\Controllers\AIGController@fileFormatNotMatch')->name('fileFormatNotMatch');
});
Route::group(['prefix' => 'projects'], function() {
    Route::any('project_file_not_in_folder', 'App\Http\Controllers\ProjectController@projectFileNotInFolder');
    Route::any('sioux_land_mental_health', 'App\Http\Controllers\ProjectAutomationController@siouxlandMentalHealth');
    Route::any('saco_river_medical_group', 'App\Http\Controllers\ProjectAutomationController@sacoRiverMedicalGroup');
    Route::any('cancer_care_specialist_ip', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistIP');
    Route::any('inventory_exe_file', 'App\Http\Controllers\ProjectAutomationController@inventoryExeFile');
    Route::any('saco_river_medical_group_duplicate', 'App\Http\Controllers\ProjectAutomationController@sacoRiverMedicalGroupDuplicates');
    Route::any('project_error_mail', 'App\Http\Controllers\ProjectController@projectErrorMail');
    Route::any('sioux_land_mental_health_duplicate', 'App\Http\Controllers\ProjectAutomationController@siouxlandMentalHealthDuplicates');
    Route::any('cancer_care_specialist_ip_duplicate', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistIPDuplicates');
    Route::any('cancer_care_specialist_op', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistOP');
    Route::any('cancer_care_specialist_op_duplicate', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistOPDuplicates');
    Route::any('cancer_care_specialist_pic', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistPIC');
    Route::any('cancer_care_specialist_pic_duplicate', 'App\Http\Controllers\ProjectAutomationController@cancerCareSpecialistPICDuplicates');
    Route::any('tallahassee_orthopedic_clinic_claim_edits', 'App\Http\Controllers\ProjectAutomationController@TallahasseeOrthopedicClinicClaimEdits');
    Route::any('tallahassee_orthopedic_clinic_claim_edits_duplicate', 'App\Http\Controllers\ProjectAutomationController@TallahasseeOrthopedicClinicClaimEditsDuplicates');
    Route::any('tallahassee_orthopedic_clinic_denial', 'App\Http\Controllers\ProjectAutomationController@TallahasseeOrthopedicClinicDenail');
    Route::any('tallahassee_orthopedic_clinic_denial_duplicate', 'App\Http\Controllers\ProjectAutomationController@TallahasseeOrthopedicClinicDenialDuplicates');
    Route::any('chestnut_health_systems_inc_em_op', 'App\Http\Controllers\ProjectAutomationController@chestnutHealthSystemsIncEmOp');
    Route::any('chestnut_health_systems_inc_em_op_duplicates', 'App\Http\Controllers\ProjectAutomationController@chestnutHealthSystemsIncEmOpDuplicates');
    Route::any('restoration_healthcare_em_op', 'App\Http\Controllers\ProjectAutomationController@restorationHealthcareEmOp');
    Route::any('restoration_healthcare_em_op_duplicates', 'App\Http\Controllers\ProjectAutomationController@restorationHealthcareEmOpDuplicates');
});