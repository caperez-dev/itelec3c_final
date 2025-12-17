<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voter extends Model
{
    use SoftDeletes;
    
    //Name of table
    protected $table = 'voters';
    protected $primaryKey = 'voter_id';
    
    // Fields
    protected $fillable = [
        'voter_key',
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'contact_information',
        'imagepath',
        'has_voted',
        'status',
    ];
    
    protected $casts = [
        'birthdate' => 'date',
        'has_voted' => 'boolean',
        'deleted_at' => 'datetime',
    ];
    
    // Dates for soft deletes
    protected $dates = ['deleted_at'];
}