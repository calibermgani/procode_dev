<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryWoundDuplicate extends Model
{
    use SoftDeletes;
    protected $table ='inventory_wound_duplicates';
   protected $fillable = [
    'ticket_number','doctor','insurance_carrier','insurance_group','patient_id','patient_name','dob','dos','doe','department','facility','company','pos',
    'coders_em_cpt','coders_em_icd_10','coders_procedure_cpt','coders_procedure_icd_10','billers_audit_cpt_comments','billers_audit_icd','doctors_mr_cpt','em_dx','severity_of_diagnosis',
    'amount_and_or_complexity_of_data','risk_of_complications_and_or_morbidity','rationale','visit_status','visit_desc','cpt','units','modifier','diagnoses','coder_comment',
    'inventory_date','CE_emp_id','QA_emp_id','status'
    ];
}
