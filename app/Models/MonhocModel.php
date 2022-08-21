<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonhocModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['mahp', 'tenhp', 'tinchi', 'tinchilt', 'sotietlt', 'tinchith', 'sotietth', 'ghichuhp', 'status','create_at'];
    protected $primaryKey = 'mahp';
    protected $table = 'monhoc';
}
