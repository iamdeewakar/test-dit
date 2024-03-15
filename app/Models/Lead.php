<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'unique_query_id',
        'query_type',
        'sender_name',
        'sender_mobile',
        'sender_email',
        'sender_company',
        'sender_address',
        'sender_city',
        'sender_state',
        'sender_pincode',
        'sender_country_iso',
        'sender_mobile_alt',
        'sender_phone',
        'sender_phone_alt',
        'sender_email_alt',
        'query_product_name',
        'query_message',
        'query_mcat_name',	
        'call_duration',
        'receiver_mobile',
    ];
}
