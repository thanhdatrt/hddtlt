<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtdtModel extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'mahp', 'manganh', 'mahe', 'khoactdt', 'stt', 'tuchon', 'sotinchitc', 'status', 'create_at'];
    protected $primaryKey = 'mahp';
    protected $table = 'ctdt';


    
}
