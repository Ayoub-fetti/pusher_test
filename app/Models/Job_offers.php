<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Job_offers extends Model
{
    protected $fillable = [
        'company_name',
        'title',
        'description',
        'location',
        'contract_type',
        'offer_link',
        'date_published',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
