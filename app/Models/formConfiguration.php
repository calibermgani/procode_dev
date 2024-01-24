<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class formConfiguration extends Model
{
    use SoftDeletes;
    protected $table ='form_configurations';
   protected $fillable = ['project_name','sub_project_name','label_name','input_type','options_name','field_type','field_type_1','field_type_2','added_by'];
//    protected $casts = [
//     'label_name' => 'array',
//     'input_type' => 'array',
//     'options_name' => 'array',
//     'field_type' => 'array',
//     'field_type_1' => 'array',
//     'field_type_2' => 'array'
//     ];
}
