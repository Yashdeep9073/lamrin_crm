<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'assigned_fee_id',
        'student_enroll_id',
        'paid_amount',
        'fine_amount',
        'discount_amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'note',
        'created_by',
    ];

    // (Optional) Add relationships
    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }


    public function category()
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }



}
