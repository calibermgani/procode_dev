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

class ProjectAutomationController extends Controller
{
    public function siouxlandMentalHealth(Request $request)
    {
        try {
            $existing = SiouxlandMentalHealthCenterProject::where('cliam_no', $request->cliam_no)->first();
            if ($existing) {
                SiouxlandMentalHealthCenterProjectDuplicates::insert([
                    'cliam_no' => isset($request->cliam_no) ? $request->cliam_no : null,
                    'mrn' => isset($request->mrn) ? $request->mrn : null,
                    'patient' => isset($request->patient) ? $request->patient : null,
                    'dob' => isset($request->dob) ? $request->dob : null,
                    'visit_date' => isset($request->visit_date) ? $request->visit_date : null,
                    'dx_codes' => isset($request->dx_codes) ? $request->dx_codes : null,
                    'primary_insurance' => isset($request->primary_insurance) ? $request->primary_insurance : null,
                    'secondary_insurance' => isset($request->secondary_insurance) ? $request->secondary_insurance : null,
                    'rev_code' => isset($request->rev_code) ? $request->rev_code : null, //Rev. Code
                    'cpt' => isset($request->cpt) ? $request->cpt : null,
                    'm1' => isset($request->m1) ? $request->m1 : null,
                    'm2' => isset($request->m2) ? $request->m2 : null,
                    'm3' => isset($request->m3) ? $request->m3 : null,
                    'm4' => isset($request->m4) ? $request->m4 : null,
                    'dx1' => isset($request->dx1) ? $request->dx1 : null,
                    'dx2' => isset($request->dx2) ? $request->dx2 : null,
                    'dx3' => isset($request->dx3) ? $request->dx3 : null,
                    'dx4' => isset($request->dx4) ? $request->dx4 : null,
                    'units' => isset($request->units) ? $request->units : null, //Billed($)
                    'billed' => isset($request->billed) ? $request->billed : null, //Allowed($)
                    'provider' => isset($request->provider) ? $request->provider : null,
                    'service_provider' => isset($request->service_provider) ? $request->service_provider : null,
                    'place_of_service' => isset($request->place_of_service) ? $request->place_of_service : null,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : null,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : null,
                    'chart_status' => "CE_Assigned",
                    'duplicate_status' => "Yes"
                ]);
            } else {
                SiouxlandMentalHealthCenterProject::insert([
                    'cliam_no' => isset($request->cliam_no) ? $request->cliam_no : null,
                    'mrn' => isset($request->mrn) ? $request->mrn : null,
                    'patient' => isset($request->patient) ? $request->patient : null,
                    'dob' => isset($request->dob) ? $request->dob : null,
                    'visit_date' => isset($request->visit_date) ? $request->visit_date : null,
                    'dx_codes' => isset($request->dx_codes) ? $request->dx_codes : null,
                    'primary_insurance' => isset($request->primary_insurance) ? $request->primary_insurance : null,
                    'secondary_insurance' => isset($request->secondary_insurance) ? $request->secondary_insurance : null,
                    'rev_code' => isset($request->rev_code) ? $request->rev_code : null, //Rev. Code
                    'cpt' => isset($request->cpt) ? $request->cpt : null,
                    'm1' => isset($request->m1) ? $request->m1 : null,
                    'm2' => isset($request->m2) ? $request->m2 : null,
                    'm3' => isset($request->m3) ? $request->m3 : null,
                    'm4' => isset($request->m4) ? $request->m4 : null,
                    'dx1' => isset($request->dx1) ? $request->dx1 : null,
                    'dx2' => isset($request->dx2) ? $request->dx2 : null,
                    'dx3' => isset($request->dx3) ? $request->dx3 : null,
                    'dx4' => isset($request->dx4) ? $request->dx4 : null,
                    'units' => isset($request->units) ? $request->units : null, //Billed($)
                    'billed' => isset($request->billed) ? $request->billed : null, //Allowed($)
                    'provider' => isset($request->provider) ? $request->provider : null,
                    'service_provider' => isset($request->service_provider) ? $request->service_provider : null,
                    'place_of_service' => isset($request->place_of_service) ? $request->place_of_service : null,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : null,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : null,
                    'chart_status' => "CE_Assigned",
                ]);
            }
            return response()->json(['message' => 'Record Inserted Successfully']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function sacoRiverMedicalGroup(Request $request)
    {
        try {
            $existing = SacoRiverMedicalGroupCoding::where('slip', $request->slip)->first();
            if ($existing) {
                SacoRiverMedicalGroupCodingDuplicates::insert([
                    'slip' => isset($request->slip) ? $request->slip : null,
                    'date_of_service' => isset($request->date_of_service) ? $request->date_of_service : null,
                    'patient_name' => isset($request->patient_name) ? $request->patient_name : null,
                    'patient_id' => isset($request->patient_id) ? $request->patient_id : null,
                    'provider' => isset($request->provider) ? $request->provider : null,
                    'department' => isset($request->department) ? $request->department : null,
                    'appointment_type' => isset($request->appointment_type) ? $request->appointment_type : null,
                    'day_of_week' => isset($request->day_of_week) ? $request->day_of_week : null,
                    'insurance' => isset($request->insurance) ? $request->insurance : null,
                    'appointment_status' => isset($request->appointment_status) ? $request->appointment_status : null,
                    'encounter_status' => isset($request->encounter_status) ? $request->encounter_status : null,
                    'provider_review' => isset($request->provider_review) ? $request->provider_review : null,
                    'charge_entry_status' => isset($request->charge_entry_status) ? $request->charge_entry_status : null,
                    'cpt' => isset($request->cpt) ? $request->cpt : null,
                    'icd' => isset($request->icd) ? $request->icd : null,
                    'am_cpt' => isset($request->am_cpt) ? $request->am_cpt : null,
                    'am_icd' => isset($request->am_icd) ? $request->am_icd : null,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : null,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : null,
                    'chart_status' => "CE_Assigned",
                    'duplicate_status' => "Yes"
                ]);
            } else {
                SacoRiverMedicalGroupCoding::insert([
                    'slip' => isset($request->slip) ? $request->slip : null,
                    'date_of_service' => isset($request->date_of_service) ? $request->date_of_service : null,
                    'patient_name' => isset($request->patient_name) ? $request->patient_name : null,
                    'patient_id' => isset($request->patient_id) ? $request->patient_id : null,
                    'provider' => isset($request->provider) ? $request->provider : null,
                    'department' => isset($request->department) ? $request->department : null,
                    'appointment_type' => isset($request->appointment_type) ? $request->appointment_type : null,
                    'day_of_week' => isset($request->day_of_week) ? $request->day_of_week : null,
                    'insurance' => isset($request->insurance) ? $request->insurance : null,
                    'appointment_status' => isset($request->appointment_status) ? $request->appointment_status : null,
                    'encounter_status' => isset($request->encounter_status) ? $request->encounter_status : null,
                    'provider_review' => isset($request->provider_review) ? $request->provider_review : null,
                    'charge_entry_status' => isset($request->charge_entry_status) ? $request->charge_entry_status : null,
                    'cpt' => isset($request->cpt) ? $request->cpt : null,
                    'icd' => isset($request->icd) ? $request->icd : null,
                    'am_cpt' => isset($request->am_cpt) ? $request->am_cpt : null,
                    'am_icd' => isset($request->am_icd) ? $request->am_icd : null,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) ? $request->CE_emp_id : null,
                    'QA_emp_id' => isset($request->QA_emp_id) ? $request->QA_emp_id : null,
                    'chart_status' => "CE_Assigned",
                ]);
            }
            return response()->json(['message' => 'Record Inserted Successfully']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
