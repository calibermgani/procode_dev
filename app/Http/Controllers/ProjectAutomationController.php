<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectWorkMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SiouxlandMentalHealthCenterProject;
use App\Models\SiouxlandMentalHealthCenterProjectDuplicates;
use App\Models\SacoRiverMedicalGroupCoding;
use App\Models\SacoRiverMedicalGroupCodingDuplicates;
use App\Models\CancerCareSpecialistsProject;
use App\Models\CancerCareSpecialistsProjectDuplicates;
class ProjectAutomationController extends Controller
{
    public function siouxlandMentalHealth(Request $request)
    {
        try {
            $currentDate = Carbon::now()->format('Y-m-d');
                if(isset($request->claim_no)) {
                    $existing = SiouxlandMentalHealthCenterProject::where('claim_no', $request->claim_no)->first();
                    $duplicateRecord =  SiouxlandMentalHealthCenterProjectDuplicates::where('claim_no', $request->claim_no)->whereDate('created_at',$currentDate)->first();
                } else {
                    $existing = null;
                    $duplicateRecord = null;
                }
            if ($existing !== null) {
                    if($duplicateRecord != null) {
                            $duplicateRecord->update([
                                'claim_no' => isset($request->claim_no) ? $request->claim_no : NULL,//Claim #
                                'mrn' => isset($request->mrn) ? $request->mrn : NULL,
                                'patient' => isset($request->patient) ? $request->patient : NULL,
                                'dob' => isset($request->dob) ? $request->dob : NULL,
                                'visit_date' => isset($request->visit_date) ? $request->visit_date : NULL,
                                'dx_codes' => isset($request->dx_codes) ? $request->dx_codes : NULL,
                                'primary_insurance' => isset($request->primary_insurance) ? $request->primary_insurance : NULL,
                                'secondary_insurance' => isset($request->secondary_insurance) ? $request->secondary_insurance : NULL,
                                'rev_code' => isset($request->rev_code) ? $request->rev_code : NULL, //Rev. Code
                                'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                                'm1' => isset($request->m1) ? $request->m1 : NULL,
                                'm2' => isset($request->m2) ? $request->m2 : NULL,
                                'm3' => isset($request->m3) ? $request->m3 : NULL,
                                'm4' => isset($request->m4) ? $request->m4 : NULL,
                                'dx1' => isset($request->dx1) ? $request->dx1 : NULL,
                                'dx2' => isset($request->dx2) ? $request->dx2 : NULL,
                                'dx3' => isset($request->dx3) ? $request->dx3 : NULL,
                                'dx4' => isset($request->dx4) ? $request->dx4 : NULL,
                                'units' => isset($request->units) ? $request->units : NULL,
                                'billed' => isset($request->billed) ? $request->billed : NULL, //Billed($)
                                'provider' => isset($request->provider) ? $request->provider : NULL,
                                'service_provider' => isset($request->service_provider) ? $request->service_provider : NULL,
                                'place_of_service' => isset($request->place_of_service) ? $request->place_of_service : NULL,
                                'invoke_date' => carbon::now()->format('Y-m-d'),
                                'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                                'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                                'chart_status' => "CE_Assigned",
                                'duplicate_status' => "Yes"
                            ]);
                            return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                    } else {
                            SiouxlandMentalHealthCenterProjectDuplicates::insert([
                                'claim_no' => isset($request->claim_no) ? $request->claim_no : NULL,//Claim #
                                'mrn' => isset($request->mrn) ? $request->mrn : NULL,
                                'patient' => isset($request->patient) ? $request->patient : NULL,
                                'dob' => isset($request->dob) ? $request->dob : NULL,
                                'visit_date' => isset($request->visit_date) ? $request->visit_date : NULL,
                                'dx_codes' => isset($request->dx_codes) ? $request->dx_codes : NULL,
                                'primary_insurance' => isset($request->primary_insurance) ? $request->primary_insurance : NULL,
                                'secondary_insurance' => isset($request->secondary_insurance) ? $request->secondary_insurance : NULL,
                                'rev_code' => isset($request->rev_code) ? $request->rev_code : NULL, //Rev. Code
                                'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                                'm1' => isset($request->m1) ? $request->m1 : NULL,
                                'm2' => isset($request->m2) ? $request->m2 : NULL,
                                'm3' => isset($request->m3) ? $request->m3 : NULL,
                                'm4' => isset($request->m4) ? $request->m4 : NULL,
                                'dx1' => isset($request->dx1) ? $request->dx1 : NULL,
                                'dx2' => isset($request->dx2) ? $request->dx2 : NULL,
                                'dx3' => isset($request->dx3) ? $request->dx3 : NULL,
                                'dx4' => isset($request->dx4) ? $request->dx4 : NULL,
                                'units' => isset($request->units) ? $request->units : NULL,
                                'billed' => isset($request->billed) ? $request->billed : NULL, //Billed($)
                                'provider' => isset($request->provider) ? $request->provider : NULL,
                                'service_provider' => isset($request->service_provider) ? $request->service_provider : NULL,
                                'place_of_service' => isset($request->place_of_service) ? $request->place_of_service : NULL,
                                'invoke_date' => carbon::now()->format('Y-m-d'),
                                'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                                'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                                'chart_status' => "CE_Assigned",
                                'duplicate_status' => "Yes"
                            ]);
                            return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                    }
                
            } else {
                SiouxlandMentalHealthCenterProject::insert([
                    'claim_no' => isset($request->claim_no) ? $request->claim_no : NULL,//Claim #
                    'mrn' => isset($request->mrn) ? $request->mrn : NULL,
                    'patient' => isset($request->patient) ? $request->patient : NULL,
                    'dob' => isset($request->dob) ? $request->dob : NULL,
                    'visit_date' => isset($request->visit_date) ? $request->visit_date : NULL,
                    'dx_codes' => isset($request->dx_codes) ? $request->dx_codes : NULL,
                    'primary_insurance' => isset($request->primary_insurance) ? $request->primary_insurance : NULL,
                    'secondary_insurance' => isset($request->secondary_insurance) ? $request->secondary_insurance : NULL,
                    'rev_code' => isset($request->rev_code) ? $request->rev_code : NULL, //Rev. Code
                    'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                    'm1' => isset($request->m1) ? $request->m1 : NULL,
                    'm2' => isset($request->m2) ? $request->m2 : NULL,
                    'm3' => isset($request->m3) ? $request->m3 : NULL,
                    'm4' => isset($request->m4) ? $request->m4 : NULL,
                    'dx1' => isset($request->dx1) ? $request->dx1 : NULL,
                    'dx2' => isset($request->dx2) ? $request->dx2 : NULL,
                    'dx3' => isset($request->dx3) ? $request->dx3 : NULL,
                    'dx4' => isset($request->dx4) ? $request->dx4 : NULL,
                    'units' => isset($request->units) ? $request->units : NULL,
                    'billed' => isset($request->billed) ? $request->billed : NULL, //Billed($)
                    'provider' => isset($request->provider) ? $request->provider : NULL,
                    'service_provider' => isset($request->service_provider) ? $request->service_provider : NULL,
                    'place_of_service' => isset($request->place_of_service) ? $request->place_of_service : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned",
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialist(Request $request)
    {
        try {
            $currentDate = Carbon::now()->format('Y-m-d');
                    if(isset($request->encounter)) {
                        $existing = CancerCareSpecialistsProject::where('encounter', $request->encounter)->where('invoke_date',$currentDate)->first();
                        $duplicateRecord =  CancerCareSpecialistsProjectDuplicates::where('encounter', $request->encounter)->whereDate('created_at',$currentDate)->first();
                    } else {
                        $existing = null;
                        $duplicateRecord = null;
                    }
                if ($existing !== null) {
                    if($duplicateRecord != null) {
                            $duplicateRecord->update([
                                'encounter' => isset($request->encounter) ? $request->encounter : NULL,
                                'charge_code' => isset($request->charge_code) ? $request->charge_code : NULL,
                                'patient' => isset($request->patient) ? $request->patient : NULL,
                                'rule' => isset($request->rule) ? $request->rule : NULL,
                                'date_of_service_range' => isset($request->date_of_service_range) ? $request->date_of_service_range : NULL,
                                'rendering_provider' => isset($request->rendering_provider) ? $request->rendering_provider : NULL,
                                'facility' => isset($request->facility) ? $request->facility : NULL,
                                'primary_policy' => isset($request->primary_policy) ? $request->primary_policy : NULL,
                                'supervising_provider' => isset($request->supervising_provider) ? $request->supervising_provider : NULL, 
                                'referring_provider' => isset($request->referring_provider) ? $request->referring_provider : NULL,
                                'supporting_providers' => isset($request->supporting_providers) ? $request->supporting_providers : NULL,
                                'modifiers' => isset($request->modifiers) ? $request->modifiers : NULL,
                                'invoke_date' => carbon::now()->format('Y-m-d'),
                                'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                                'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                                'chart_status' => "CE_Assigned",
                                'duplicate_status' => "Yes"
                            ]);
                            return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                    } else {
                        CancerCareSpecialistsProjectDuplicates::insert([
                               'encounter' => isset($request->encounter) ? $request->encounter : NULL,
                                'charge_code' => isset($request->charge_code) ? $request->charge_code : NULL,
                                'patient' => isset($request->patient) ? $request->patient : NULL,
                                'rule' => isset($request->rule) ? $request->rule : NULL,
                                'date_of_service_range' =>  isset($request->date_of_service_range) ? $request->date_of_service_range : NULL,
                                'rendering_provider' => isset($request->rendering_provider) ? $request->rendering_provider : NULL,
                                'facility' => isset($request->facility) ? $request->facility : NULL,
                                'primary_policy' => isset($request->primary_policy) ? $request->primary_policy : NULL,
                                'supervising_provider' => isset($request->supervising_provider) ? $request->supervising_provider : NULL, 
                                'referring_provider' => isset($request->referring_provider) ? $request->referring_provider : NULL,
                                'supporting_providers' => isset($request->supporting_providers) ? $request->supporting_providers : NULL,
                                'modifiers' => isset($request->modifiers) ? $request->modifiers : NULL,
                                'invoke_date' => carbon::now()->format('Y-m-d'),
                                'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                                'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                                'chart_status' => "CE_Assigned",
                                'duplicate_status' => "Yes"
                            ]);
                            return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                    }
                
            } else {
                CancerCareSpecialistsProject::insert([
                   'encounter' => isset($request->encounter) ? $request->encounter : NULL,
                    'charge_code' => isset($request->charge_code) ? $request->charge_code : NULL,
                    'patient' => isset($request->patient) ? $request->patient : NULL,
                    'rule' => isset($request->rule) ? $request->rule : NULL,
                    'date_of_service_range' =>  isset($request->date_of_service_range) ? $request->date_of_service_range : NULL,
                    'rendering_provider' => isset($request->rendering_provider) ? $request->rendering_provider : NULL,
                    'facility' => isset($request->facility) ? $request->facility : NULL,
                    'primary_policy' => isset($request->primary_policy) ? $request->primary_policy : NULL,
                    'supervising_provider' => isset($request->supervising_provider) ? $request->supervising_provider : NULL, 
                    'referring_provider' => isset($request->referring_provider) ? $request->referring_provider : NULL,
                    'supporting_providers' => isset($request->supporting_providers) ? $request->supporting_providers : NULL,
                    'modifiers' => isset($request->modifiers) ? $request->modifiers : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned",
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
    public function sacoRiverMedicalGroup(Request $request)
    {
        try {
            $currentDate = Carbon::now()->format('Y-m-d');
              if(isset($request->patient_id)) {
                $existing = SacoRiverMedicalGroupCoding::where('patient_id', $request->patient_id)->where('invoke_date',$currentDate)->first();
                $duplicateRecord =  SacoRiverMedicalGroupCodingDuplicates::where('patient_id', $request->patient_id)->whereDate('created_at',$currentDate)->first();
            } else {
                $existing = null;
                $duplicateRecord = null;
            }
            if ($existing != null) {
                if($duplicateRecord != null) {
                        $duplicateRecord->update([
                            'slip' => isset($request->slip) ? $request->slip : NULL,
                            'date_of_service' => isset($request->date_of_service) ? $request->date_of_service : NULL,
                            'patient_name' => isset($request->patient_name) ? $request->patient_name : NULL,
                            'patient_id' => isset($request->patient_id) ? $request->patient_id : NULL,
                            'provider' => isset($request->provider) ? $request->provider : NULL,
                            'department' => isset($request->department) ? $request->department : NULL,
                            'appointment_type' => isset($request->appointment_type) ? $request->appointment_type : NULL,
                            'day_of_week' => isset($request->day_of_week) ? $request->day_of_week : NULL,
                            'insurance' => isset($request->insurance) ? $request->insurance : NULL,
                            'appointment_status' => isset($request->appointment_status) ? $request->appointment_status : NULL,
                            'encounter_status' => isset($request->encounter_status) ? $request->encounter_status : NULL,
                            'provider_review' => isset($request->provider_review) ? $request->provider_review : NULL,
                            'charge_entry_status' => isset($request->charge_entry_status) ? $request->charge_entry_status : NULL,
                            'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                            'icd' => isset($request->icd) ? $request->icd : NULL,
                            'am_cpt' => isset($request->am_cpt) ? $request->am_cpt : NULL,
                            'am_icd' => isset($request->am_icd) ? $request->am_icd : NULL,
                            'invoke_date' => carbon::now()->format('Y-m-d'),
                            'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                            'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                            'chart_status' => "CE_Assigned",
                            'duplicate_status' => "Yes"
                        ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                } else {
                    SacoRiverMedicalGroupCodingDuplicates::insert([
                        'slip' => isset($request->slip) ? $request->slip : NULL,
                        'date_of_service' => isset($request->date_of_service) ? $request->date_of_service : NULL,
                        'patient_name' => isset($request->patient_name) ? $request->patient_name : NULL,
                        'patient_id' => isset($request->patient_id) ? $request->patient_id : NULL,
                        'provider' => isset($request->provider) ? $request->provider : NULL,
                        'department' => isset($request->department) ? $request->department : NULL,
                        'appointment_type' => isset($request->appointment_type) ? $request->appointment_type : NULL,
                        'day_of_week' => isset($request->day_of_week) ? $request->day_of_week : NULL,
                        'insurance' => isset($request->insurance) ? $request->insurance : NULL,
                        'appointment_status' => isset($request->appointment_status) ? $request->appointment_status : NULL,
                        'encounter_status' => isset($request->encounter_status) ? $request->encounter_status : NULL,
                        'provider_review' => isset($request->provider_review) ? $request->provider_review : NULL,
                        'charge_entry_status' => isset($request->charge_entry_status) ? $request->charge_entry_status : NULL,
                        'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                        'icd' => isset($request->icd) ? $request->icd : NULL,
                        'am_cpt' => isset($request->am_cpt) ? $request->am_cpt : NULL,
                        'am_icd' => isset($request->am_icd) ? $request->am_icd : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned",
                        'duplicate_status' => "Yes"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                }
            } else {
                SacoRiverMedicalGroupCoding::insert([
                    'slip' => isset($request->slip) ? $request->slip : NULL,
                    'date_of_service' => isset($request->date_of_service) ? $request->date_of_service : NULL,
                    'patient_name' => isset($request->patient_name) ? $request->patient_name : NULL,
                    'patient_id' => isset($request->patient_id) ? $request->patient_id : NULL,
                    'provider' => isset($request->provider) ? $request->provider : NULL,
                    'department' => isset($request->department) ? $request->department : NULL,
                    'appointment_type' => isset($request->appointment_type) ? $request->appointment_type : NULL,
                    'day_of_week' => isset($request->day_of_week) ? $request->day_of_week : NULL,
                    'insurance' => isset($request->insurance) ? $request->insurance : NULL,
                    'appointment_status' => isset($request->appointment_status) ? $request->appointment_status : NULL,
                    'encounter_status' => isset($request->encounter_status) ? $request->encounter_status : NULL,
                    'provider_review' => isset($request->provider_review) ? $request->provider_review : NULL,
                    'charge_entry_status' => isset($request->charge_entry_status) ? $request->charge_entry_status : NULL,
                    'cpt' => isset($request->cpt) ? $request->cpt : NULL,
                    'icd' => isset($request->icd) ? $request->icd : NULL,
                    'am_cpt' => isset($request->am_cpt) ? $request->am_cpt : NULL,
                    'am_icd' => isset($request->am_icd) ? $request->am_icd : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned",
                ]);
            }
            return response()->json(['message' => 'Record Inserted Successfully']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
