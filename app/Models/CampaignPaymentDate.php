<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignPaymentDate extends Model
{
    protected $fillable = ['campaign_id', 'payment_date', 'amount_idr'];
}
