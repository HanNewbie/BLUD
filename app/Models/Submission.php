<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class Submission extends Model
{
    protected $table = 'submission';

    protected $fillable = [
        'user_id',
        'namePIC',
        'no_hp',
        'address',
        'vendor',
        'location',
        'apply_date',
        'start_date',
        'end_date',
        'name_event',
        'file',
        'ktp',
        'appl_letter',
        'actv_letter',
        'status',
        'notes',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'name');
    }

}
