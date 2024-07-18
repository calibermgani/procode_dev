<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectWorkMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SmhcCodingEm;
use App\Models\SmhcCodingEmDuplicates;
use App\Models\SrmgCoding;
use App\Models\SrmgCodingDuplicates;
use App\Models\CcsIp;
use App\Models\CcsIpDuplicates;
use App\Models\ChestnutHealthSystemsClaimEdits;
use App\Models\ChestnutHealthSystemsClaimEditsDuplicates;
use App\Models\InventoryExeFile;
use GuzzleHttp\Client;
use App\Models\CCEmailIds;
use App\Mail\ProcodeInventoryExeFile;
use App\Http\Helper\Admin\Helpers as Helpers;
use App\Models\InventoryErrorLogs;
use App\Models\CcsOp;
use App\Models\CcsOpDuplicates;
use App\Models\CcsPic;
use App\Models\CcsPicDuplicates;
use App\Models\TocClaimEdits;
use App\Models\TocClaimEditsDuplicates;
use App\Models\TocDenial;
use App\Models\TocDenialDuplicates;
class ProjectAutomationController extends Controller
{
    public function siouxlandMentalHealth(Request $request)
    {
        try {
            $attributes = [
                'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                // 'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                // 'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                // 'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                // 'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                // 'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                // 'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                // 'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                // 'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                // 'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                // 'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                // 'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                // 'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                // 'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                // 'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                // 'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                // 'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                // 'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                // 'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                // 'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                // 'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];
            $existing = SmhcCodingEm::where($attributes)->exists();
            if (!$existing) {
                SmhcCodingEm::insert([
                    'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                    'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                    'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                    'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                    'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                    'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                    'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                    'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                    'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                    'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                    'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                    'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                    'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                    'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                    'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                    'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                    'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                    'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                    'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                    'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                    'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                    'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                    'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting =  SmhcCodingEmDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    SmhcCodingEmDuplicates::insert([
                        'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                        'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                        'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                        'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                        'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                        'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                        'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                        'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                        'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                        'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                        'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                        'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                        'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                        'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                        'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                        'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                        'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                        'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                        'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                        'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  SmhcCodingEmDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                        'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                        'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                        'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                        'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                        'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                        'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                        'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                        'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                        'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                        'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                        'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                        'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                        'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                        'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                        'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                        'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                        'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                        'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                        'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistIP(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = CcsIp::where($attributes)->exists();
            if (!$existing) {
                CcsIp::insert([
                    'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                    'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                    'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                    'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                    'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                    'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                    'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                    'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                    'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                    'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                    'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                    'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting =  CcsIpDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsIpDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsIpDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
    public function sacoRiverMedicalGroup(Request $request)
    {
        try {
            $attributes = [
                // 'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                // 'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                // 'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                // 'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                // 'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                // 'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                // 'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                // 'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                // 'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                // 'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                // 'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                // 'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                // 'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                // 'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = SrmgCoding::where($attributes)->exists();
            if (!$existing) {
                SrmgCoding::insert([
                    'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                    'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                    'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                    'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                    'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                    'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                    'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                    'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                    'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                    'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                    'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                    'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                    'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                    'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                    'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                    'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                    'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned",
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting  =  SrmgCodingDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    SrmgCodingDuplicates::insert([
                        'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                        'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                        'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                        'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                        'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                        'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                        'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                        'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                        'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                        'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                        'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                        'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned",
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  SrmgCodingDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                        'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                        'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                        'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                        'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                        'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                        'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                        'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                        'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                        'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                        'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                        'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned",
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function chestnutHealthSystems(Request $request)
    {
        try {
            $attributes = [
                'claim_type' => isset($request->claim_type) && $request->claim_type != "NULL" ? $request->claim_type : NULL,
                'claims_no' => isset($request->claims_no) && $request->claims_no != "NULL" ? $request->claims_no : NULL,
                'service_date' => isset($request->service_date) && $request->service_date != "NULL" ? $request->service_date : NULL,
                'pvdr' => isset($request->pvdr) && $request->pvdr != "NULL" ? $request->pvdr : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL" ? $request->patient : NULL,
                'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                'status' => isset($request->status) && $request->status != "NULL" ? $request->status : NULL,
                'charges' => isset($request->charges) && $request->charges != "NULL" ? $request->charges : NULL,
                'pmts_adjs' => isset($request->pmts_adjs) && $request->pmts_adjs != "NULL" ? $request->pmts_adjs : NULL,
                'adjustment' => isset($request->adjustment) && $request->adjustment != "NULL" ? $request->adjustment : NULL,
                'withheld' => isset($request->withheld) && $request->withheld != "NULL" ? $request->withheld : NULL,
                'balance' => isset($request->balance) && $request->balance != "NULL" ? $request->balance : NULL,
                'account_number' => isset($request->account_number) && $request->account_number != "NULL" ? $request->account_number : NULL,
                'provider_name' => isset($request->provider_name) && $request->provider_name != "NULL" ? $request->provider_name : NULL,
                'guarantor_name' => isset($request->guarantor_name) && $request->guarantor_name != "NULL" ? $request->guarantor_name : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = ChestnutHealthSystemsClaimEdits::where($attributes)->exists();
            if (!$existing) {
                ChestnutHealthSystemsClaimEdits::insert([
                    'claim_type' => isset($request->claim_type) && $request->claim_type != "NULL" ? $request->claim_type : NULL,
                    'claims_no' => isset($request->claims_no) && $request->claims_no != "NULL" ? $request->claims_no : NULL,
                    'service_date' => isset($request->service_date) && $request->service_date != "NULL" ? $request->service_date : NULL,
                    'pvdr' => isset($request->pvdr) && $request->pvdr != "NULL" ? $request->pvdr : NULL,
                    'patient' => isset($request->patient) && $request->patient != "NULL" ? $request->patient : NULL,
                    'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                    'status' => isset($request->status) && $request->status != "NULL" ? $request->status : NULL,
                    'charges' => isset($request->charges) && $request->charges != "NULL" ? $request->charges : NULL,
                    'pmts_adjs' => isset($request->pmts_adjs) && $request->pmts_adjs != "NULL" ? $request->pmts_adjs : NULL,
                    'adjustment' => isset($request->adjustment) && $request->adjustment != "NULL" ? $request->adjustment : NULL,
                    'withheld' => isset($request->withheld) && $request->withheld != "NULL" ? $request->withheld : NULL,
                    'balance' => isset($request->balance) && $request->balance != "NULL" ? $request->balance : NULL,
                    'account_number' => isset($request->account_number) && $request->account_number != "NULL" ? $request->account_number : NULL,
                    'provider_name' => isset($request->provider_name) && $request->provider_name != "NULL" ? $request->provider_name : NULL,
                    'guarantor_name' => isset($request->guarantor_name) && $request->guarantor_name != "NULL" ? $request->guarantor_name : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting  =  ChestnutHealthSystemsClaimEditsDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    ChestnutHealthSystemsClaimEditsDuplicates::insert([
                        'claim_type' => isset($request->claim_type) && $request->claim_type != "NULL" ? $request->claim_type : NULL,
                        'claims_no' => isset($request->claims_no) && $request->claims_no != "NULL" ? $request->claims_no : NULL,
                        'service_date' => isset($request->service_date) && $request->service_date != "NULL" ? $request->service_date : NULL,
                        'pvdr' => isset($request->pvdr) && $request->pvdr != "NULL" ? $request->pvdr : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL" ? $request->patient : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'status' => isset($request->status) && $request->status != "NULL" ? $request->status : NULL,
                        'charges' => isset($request->charges) && $request->charges != "NULL" ? $request->charges : NULL,
                        'pmts_adjs' => isset($request->pmts_adjs) && $request->pmts_adjs != "NULL" ? $request->pmts_adjs : NULL,
                        'adjustment' => isset($request->adjustment) && $request->adjustment != "NULL" ? $request->adjustment : NULL,
                        'withheld' => isset($request->withheld) && $request->withheld != "NULL" ? $request->withheld : NULL,
                        'balance' => isset($request->balance) && $request->balance != "NULL" ? $request->balance : NULL,
                        'account_number' => isset($request->account_number) && $request->account_number != "NULL" ? $request->account_number : NULL,
                        'provider_name' => isset($request->provider_name) && $request->provider_name != "NULL" ? $request->provider_name : NULL,
                        'guarantor_name' => isset($request->guarantor_name) && $request->guarantor_name != "NULL" ? $request->guarantor_name : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord  =  ChestnutHealthSystemsClaimEditsDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'claim_type' => isset($request->claim_type) && $request->claim_type != "NULL" ? $request->claim_type : NULL,
                        'claims_no' => isset($request->claims_no) && $request->claims_no != "NULL" ? $request->claims_no : NULL,
                        'service_date' => isset($request->service_date) && $request->service_date != "NULL" ? $request->service_date : NULL,
                        'pvdr' => isset($request->pvdr) && $request->pvdr != "NULL" ? $request->pvdr : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL" ? $request->patient : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'status' => isset($request->status) && $request->status != "NULL" ? $request->status : NULL,
                        'charges' => isset($request->charges) && $request->charges != "NULL" ? $request->charges : NULL,
                        'pmts_adjs' => isset($request->pmts_adjs) && $request->pmts_adjs != "NULL" ? $request->pmts_adjs : NULL,
                        'adjustment' => isset($request->adjustment) && $request->adjustment != "NULL" ? $request->adjustment : NULL,
                        'withheld' => isset($request->withheld) && $request->withheld != "NULL" ? $request->withheld : NULL,
                        'balance' => isset($request->balance) && $request->balance != "NULL" ? $request->balance : NULL,
                        'account_number' => isset($request->account_number) && $request->account_number != "NULL" ? $request->account_number : NULL,
                        'provider_name' => isset($request->provider_name) && $request->provider_name != "NULL" ? $request->provider_name : NULL,
                        'guarantor_name' => isset($request->guarantor_name) && $request->guarantor_name != "NULL" ? $request->guarantor_name : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function inventoryExeFile(Request $request)
    {
        try {
            $attributes = [
                'project_id' => isset($request->project_id) ? $request->project_id : NULL,
                'sub_project_id' => isset($request->sub_project_id)&& $request->sub_project_id != "NULL" ? $request->sub_project_id : NULL,
                'file_name' => isset($request->file_name) ? $request->file_name : NULL,
                'exe_date' => now()->format('Y-m-d H:i:s'),
            ];
            $whereAttributes = [
                'project_id' => isset($request->project_id) ? $request->project_id : NULL,
                'sub_project_id' => isset($request->sub_project_id) && $request->sub_project_id != "NULL" ? $request->sub_project_id : NULL,
                'file_name' => isset($request->file_name) ? $request->file_name : NULL
            ];
            $exists = InventoryExeFile::where($whereAttributes)->whereDate('exe_date', now()->format('Y-m-d'))->exists();
            if (!$exists) {
                InventoryExeFile::create($attributes);
                $currentDate = Carbon::now()->format('Y-m-d');
                if (isset($request->project_id)) {
                    $projectId = $request->project_id;
                    $clientName = Helpers::projectName($projectId)->project_name;
                    $aimsClientName = Helpers::projectName($projectId)->aims_project_name;
                    if (isset($request->sub_project_id) && $request->sub_project_id != "NULL" && $request->sub_project_id != NULL) {
                        $subProjectId = $request->sub_project_id;
                        $subProjectName = Helpers::subProjectName($projectId, $subProjectId)->sub_project_name;
                        $table_name = Str::slug((Str::lower($clientName) . '_' . Str::lower($subProjectName)), '_');
                        $prjoectName = $aimsClientName . ' - ' . $subProjectName;
                    } else {
                        $subProjectId = NULL;
                        $subProjectText = "project";
                        $table_name = Str::slug((Str::lower($clientName) . '_' . Str::lower($subProjectText)), '_');
                        $prjoectName = $aimsClientName;
                    }
                } else {
                    $projectId = NULL;
                }

                $modelName = Str::studly($table_name);
                $modelClass = "App\\Models\\" . $modelName;
                $modelClassDuplicate = "App\\Models\\" . $modelName.'Duplicates';
                $currentCount = 0;
                if (class_exists($modelClass)) {
                    $currentCount = $modelClass::where('invoke_date', $currentDate)->where('chart_status','CE_Assigned')->count();
                    $duplicateCount = $modelClassDuplicate::where('invoke_date', $currentDate)->where('chart_status','CE_Assigned')->count();
                    $assignedCount = $modelClass::where('invoke_date', $currentDate)->where('chart_status','CE_Assigned')->whereNotNull('CE_emp_id')->count();
                    $unAssignedCount = $modelClass::where('invoke_date', $currentDate)->where('chart_status','CE_Assigned')->whereNull('CE_emp_id')->count();
                }
                $procodeProjectsCurrent = [];
                Log::info($prjoectName." count is ".$currentCount);
                 if ($currentCount > 0) {
                    $procodeProjectsCurrent['project'] = $prjoectName;
                    $procodeProjectsCurrent['currentCount'] = $currentCount;
                    $procodeProjectsCurrent['duplicateCount'] = $duplicateCount;
                    $procodeProjectsCurrent['assignedCount'] = $assignedCount;
                    $procodeProjectsCurrent['unAssignedCount'] = $unAssignedCount;
                    $toMail = CCEmailIds::select('cc_emails')->where('cc_module', 'inventory exe file to mail id')->first();
                    $toMailId = explode(",", $toMail->cc_emails);
                    // $toMailId = "mgani@caliberfocus.com";
                    // $ccMailId = "vijayalaxmi@caliberfocus.com";
                    $ccMail = CCEmailIds::select('cc_emails')->where('cc_module', 'inventory exe file')->first();
                    $ccMailId = explode(",", $ccMail->cc_emails);

                    $mailDate = Carbon::now()->format('m/d/Y');
                    $mailHeader = $prjoectName . " - Inventory Upload Successful - " . $mailDate;
                    $project_information["project_id"] = $attributes["project_id"];
                    $project_information["sub_project_id"] = $attributes["sub_project_id"];
                    $project_information["error_description"] = "Default Assigned Count: " . $procodeProjectsCurrent['assignedCount'] . PHP_EOL . " Inventory Uploaded Time: " . now()->format('m/d/Y g:i A');
                    $project_information["error_status_code"] = 200;
                    $project_information["error_date"] = now()->format('Y-m-d H:i:s');
                    InventoryErrorLogs::create($project_information);
                    if (isset($toMailId) && !empty($toMailId)) {
                        try {
                            Mail::to($toMailId)->cc($ccMailId)->send(new ProcodeInventoryExeFile($mailHeader, $procodeProjectsCurrent));
                            Log::info($prjoectName."mail sent ");
                        } catch (\Exception $e) {
                            Log::error('Mail sending failed: ' . $e->getMessage());
                        }
                        
                    }
                    return response()->json(['message' => 'Inventory File Inserted Successfully']);
                  }
                return response()->json(['message' => 'Inventory mail was not sent because the count is zero']);
            } else {
                return response()->json(['message' => 'Inventory File already exists']);
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function sacoRiverMedicalGroupDuplicates(Request $request)
    {
        try {
            $attributes = [
                // 'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                // 'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                // 'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                // 'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                // 'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                // 'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                // 'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                // 'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                // 'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                // 'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                // 'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                // 'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                // 'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                // 'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting  =  SrmgCodingDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    SrmgCodingDuplicates::insert([
                        'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                        'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                        'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                        'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                        'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                        'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                        'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                        'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                        'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                        'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                        'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                        'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned",
                    ]);
                    return response()->json(['message' => 'Saco Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  SrmgCodingDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'slip' => isset($request->slip) && $request->slip != "NULL" ? $request->slip : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'patient_id' => isset($request->patient_id) && $request->patient_id != "NULL" ? $request->patient_id : NULL,
                        'provider' => isset($request->provider) && $request->provider != "NULL" ? $request->provider : NULL,
                        'department' => isset($request->department) && $request->department != "NULL" ? $request->department : NULL,
                        'appointment_type' => isset($request->appointment_type) && $request->appointment_type != "NULL" ? $request->appointment_type : NULL,
                        'day_of_week' => isset($request->day_of_week) && $request->day_of_week != "NULL" ? $request->day_of_week : NULL,
                        'insurance' => isset($request->insurance) && $request->insurance != "NULL" ? $request->insurance : NULL,
                        'appointment_status' => isset($request->appointment_status) && $request->appointment_status != "NULL" ? $request->appointment_status : NULL,
                        'encounter_status' => isset($request->encounter_status) && $request->encounter_status != "NULL" ? $request->encounter_status : NULL,
                        'provider_review' => isset($request->provider_review) && $request->provider_review != "NULL" ? $request->provider_review : NULL,
                        'charge_entry_status' => isset($request->charge_entry_status) && $request->charge_entry_status != "NULL" ? $request->charge_entry_status : NULL,
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'icd' => isset($request->icd) && $request->icd != "NULL" ? $request->icd : NULL,
                        'am_cpt' => isset($request->am_cpt) && $request->am_cpt != "NULL" ? $request->am_cpt : NULL,
                        'am_icd' => isset($request->am_icd) && $request->am_icd != "NULL" ? $request->am_icd : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned",
                    ]);
                    return response()->json(['message' => 'Saco Duplicate Record Updated Successfully']);
               
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function siouxlandMentalHealthDuplicates(Request $request)
    {
        try {
            $attributes = [
                'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                // 'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                // 'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                // 'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                // 'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                // 'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                // 'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                // 'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                // 'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                // 'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                // 'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                // 'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                // 'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                // 'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                // 'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                // 'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                // 'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                // 'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                // 'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                // 'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                // 'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];
            
                $duplicateRecordExisting =  SmhcCodingEmDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    SmhcCodingEmDuplicates::insert([
                        'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                        'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                        'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                        'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                        'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                        'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                        'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                        'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                        'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                        'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                        'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                        'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                        'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                        'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                        'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                        'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                        'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                        'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                        'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                        'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Sioux Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  SmhcCodingEmDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'claim_no' => isset($request->claim_no) && $request->claim_no != "NULL" ? $request->claim_no : NULL, //Claim #
                        'mrn' => isset($request->mrn) && $request->mrn != "NULL" ? $request->mrn : NULL,
                        'patient_name' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'dob' => isset($request->dob) && $request->dob != "NULL" ? $request->dob : NULL,
                        'visit_date' => isset($request->visit_date) && $request->visit_date != "NULL" ? $request->visit_date : NULL,
                        'dx_codes' => isset($request->dx_codes) && $request->dx_codes != "NULL" ? $request->dx_codes : NULL,
                        'primary_insurance' => isset($request->primary_insurance) && $request->primary_insurance != "NULL"  ? $request->primary_insurance : NULL,
                        'secondary_insurance' => isset($request->secondary_insurance) && $request->secondary_insurance != "NULL" ? $request->secondary_insurance : NULL,
                        'rev_code' => isset($request->rev_code) && $request->rev_code != "NULL" ? $request->rev_code : NULL, //Rev. Code
                        'cpt' => isset($request->cpt) && $request->cpt != "NULL" ? $request->cpt : NULL,
                        'm1' => isset($request->m1) && $request->m1 != "NULL"  ? $request->m1 : NULL,
                        'm2' => isset($request->m2) && $request->m2 != "NULL" ? $request->m2 : NULL,
                        'm3' => isset($request->m3) && $request->m3 != "NULL"  ? $request->m3 : NULL,
                        'm4' => isset($request->m4) && $request->m4 != "NULL"  ? $request->m4 : NULL,
                        'dx1' => isset($request->dx1) && $request->dx1 != "NULL"  ? $request->dx1 : NULL,
                        'dx2' => isset($request->dx2) && $request->dx2 != "NULL" ? $request->dx2 : NULL,
                        'dx3' => isset($request->dx3) && $request->dx3 != "NULL" ? $request->dx3 : NULL,
                        'dx4' => isset($request->dx4) && $request->dx4 != "NULL"  ? $request->dx4 : NULL,
                        'units' => isset($request->units) && $request->units != "NULL" ? $request->units : NULL,
                        'billed_$' => isset($request->billed) && $request->billed != "NULL" ? $request->billed : NULL, //Billed($)
                        'provider' => isset($request->provider) && $request->provider != "NULL"  ? $request->provider : NULL,
                        'service_provider' => isset($request->service_provider) && $request->service_provider != "NULL"  ? $request->service_provider : NULL,
                        'place_of_service' => isset($request->place_of_service) && $request->place_of_service != "NULL"  ? $request->place_of_service : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL" ? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Sioux Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistIPDuplicates(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting =  CcsIpDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsIpDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsIpDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistOP(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = CcsOp::where($attributes)->exists();
            if (!$existing) {
                CcsOp::insert([
                    'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                    'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                    'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                    'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                    'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                    'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                    'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                    'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                    'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                    'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                    'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                    'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting = CcsOpDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsOpDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsOpDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistOPDuplicates(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting =  CcsOpDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsOpDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsOpDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistPIC(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = CcsPic::where($attributes)->exists();
            if (!$existing) {
                CcsPic::insert([
                    'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                    'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                    'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                    'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                    'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                    'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                    'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                    'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                    'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                    'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                    'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                    'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting =  CcsPicDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsPicDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsPicDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function cancerCareSpecialistPICDuplicates(Request $request)
    {
        try {
            $attributes = [
                'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                // 'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                // 'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                // 'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                // 'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                // 'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                // 'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                // 'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                // 'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                // 'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                // 'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting = CcsPicDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    CcsPicDuplicates::insert([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  CcsPicDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'encounter' => isset($request->encounter) && $request->encounter != "NULL" ? $request->encounter : NULL,
                        'charge_code' => isset($request->charge_code) && $request->charge_code != "NULL" ? $request->charge_code : NULL,
                        'patient' => isset($request->patient) && $request->patient != "NULL"  ? $request->patient : NULL,
                        'rule' => isset($request->rule) && $request->rule != "NULL" ? $request->rule : NULL,
                        'date_of_service_range' =>  isset($request->date_of_service_range) && $request->date_of_service_range != "NULL" ? $request->date_of_service_range : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'facility' => isset($request->facility) && $request->facility != "NULL" ? $request->facility : NULL,
                        'primary_policy' => isset($request->primary_policy) && $request->primary_policy != "NULL" ? $request->primary_policy : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'supporting_providers' => isset($request->supporting_providers) && $request->supporting_providers != "NULL" ? $request->supporting_providers : NULL,
                        'modifiers' => isset($request->modifiers) && $request->modifiers != "NULL" ? $request->modifiers : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
    public function TallahasseeOrthopedicClinicClaimEdits(Request $request)
    {
        try {
            $attributes = [
                'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL"  ? $request->patient_name : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = TocClaimEdits::where($attributes)->exists();
            if (!$existing) {
                TocClaimEdits::insert([
                    'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                    'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                    'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                    'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                    'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                    'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                    'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                    'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                    'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                    'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                    'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                    'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                    'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                    'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                    'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                    'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                    'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                    'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                    'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                    'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                    'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                    'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                    'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                    'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                    'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                    'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                    'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting =  TocClaimEditsDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    TocClaimEditsDuplicates::insert([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  TocClaimEditsDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                       'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function TallahasseeOrthopedicClinicClaimEditsDuplicates(Request $request)
    {
        try {
            $attributes = [
                'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL"  ? $request->patient_name : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting = TocClaimEditsDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    TocClaimEditsDuplicates::insert([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  TocClaimEditsDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function TallahasseeOrthopedicClinicDenail(Request $request)
    {
        try {
            $attributes = [
                'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL"  ? $request->patient_name : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

            $existing = TocDenial::where($attributes)->exists();dd($existing,$request->all());
            if (!$existing) {
                TocDenial::insert([
                    'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                    'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                    'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                    'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                    'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                    'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                    'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                    'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                    'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                    'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                    'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                    'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                    'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                    'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                    'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                    'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                    'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                    'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                    'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                    'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                    'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                    'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                    'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                    'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                    'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                    'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                    'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                    'invoke_date' => carbon::now()->format('Y-m-d'),
                    'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                    'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                    'chart_status' => "CE_Assigned"
                ]);
                return response()->json(['message' => 'Record Inserted Successfully']);
            } else {
                $duplicateRecordExisting =  TocDenialDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    TocDenialDuplicates::insert([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  TocDenialDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                       'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function TallahasseeOrthopedicClinicDenialDuplicates(Request $request)
    {
        try {
            $attributes = [
                'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL"  ? $request->patient_name : NULL,
                'invoke_date' => carbon::now()->format('Y-m-d')
            ];

          
                $duplicateRecordExisting = TocDenialDuplicates::where($attributes)->exists();
                if (!$duplicateRecordExisting) {
                    TocDenialDuplicates::insert([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Inserted Successfully']);
                } else {
                    $duplicateRecord =  TocDenialDuplicates::where($attributes)->first();
                    $duplicateRecord->update([
                        'claim_id' => isset($request->claim_id) && $request->claim_id != "NULL" ? $request->claim_id : NULL,
                        'username' => isset($request->username) && $request->username != "NULL" ? $request->username : NULL,
                        'worklist_status' => isset($request->worklist_status) && $request->worklist_status != "NULL"  ? $request->worklist_status : NULL,
                        'pend_effective' => isset($request->pend_effective) && $request->pend_effective != "NULL" ? $request->pend_effective : NULL,
                        'pend_expires' =>  isset($request->pend_expires) && $request->pend_expires != "NULL" ? $request->pend_expires : NULL,
                        'payer' => isset($request->payer) && $request->payer != "NULL" ? $request->payer : NULL,
                        'custom_insurance_group' => isset($request->custom_insurance_group) && $request->custom_insurance_group != "NULL" ? $request->custom_insurance_group : NULL,
                        'insurance_package' => isset($request->insurance_package) && $request->insurance_package != "NULL" ? $request->insurance_package : NULL,
                        'outstanding_amount' => isset($request->outstanding_amount) && $request->outstanding_amount != "NULL" ? $request->outstanding_amount : NULL,
                        'date_of_service' => isset($request->date_of_service) && $request->date_of_service != "NULL" ? $request->date_of_service : NULL,
                        'diagnosis_codes' => isset($request->diagnosis_codes) && $request->diagnosis_codes != "NULL" ? $request->supporting_providers : NULL,
                        'procedure_code' => isset($request->procedure_code) && $request->procedure_code != "NULL" ? $request->procedure_code : NULL,
                        'hold_reason' => isset($request->hold_reason) && $request->hold_reason != "NULL" ? $request->hold_reason : NULL,
                        'hold_date' => isset($request->hold_date) && $request->hold_date != "NULL" ? $request->hold_date : NULL,
                        'days_in_status' => isset($request->days_in_status) && $request->days_in_status != "NULL" ? $request->days_in_status : NULL,
                        'primary_department' => isset($request->primary_department) && $request->primary_department != "NULL" ? $request->primary_department : NULL,
                        'patient_department' => isset($request->patient_department) && $request->patient_department != "NULL" ? $request->patient_department : NULL,
                        'service_department' => isset($request->service_department) && $request->service_department != "NULL" ? $request->service_department : NULL,
                        'supervising_provider' => isset($request->supervising_provider) && $request->supervising_provider != "NULL" ? $request->supervising_provider : NULL,
                        'rendering_provider' => isset($request->rendering_provider) && $request->rendering_provider != "NULL" ? $request->rendering_provider : NULL,
                        'referring_provider' => isset($request->referring_provider) && $request->referring_provider != "NULL" ? $request->referring_provider : NULL,
                        'patient_name' => isset($request->patient_name) && $request->patient_name != "NULL" ? $request->patient_name : NULL,
                        'worklist' => isset($request->worklist) && $request->worklist != "NULL" ? $request->worklist : NULL,
                        'last_claim_note' => isset($request->last_claim_note) && $request->last_claim_note != "NULL" ? $request->last_claim_note : NULL,
                        'claim_status' => isset($request->claim_status) && $request->claim_status != "NULL" ? $request->claim_status : NULL,
                        'specialty' => isset($request->specialty) && $request->specialty != "NULL" ? $request->specialty : NULL,
                        'escalated_on' => isset($request->escalated_on) && $request->escalated_on != "NULL" ? $request->escalated_on : NULL,
                        'invoke_date' => carbon::now()->format('Y-m-d'),
                        'CE_emp_id' => isset($request->CE_emp_id) && $request->CE_emp_id != '-' && $request->CE_emp_id != "NULL"? $request->CE_emp_id : NULL,
                        'QA_emp_id' => isset($request->QA_emp_id) && $request->QA_emp_id != '-' && $request->QA_emp_id != "NULL" ? $request->QA_emp_id : NULL,
                        'chart_status' => "CE_Assigned"
                    ]);
                    return response()->json(['message' => 'Duplicate Record Updated Successfully']);
                }
            
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
