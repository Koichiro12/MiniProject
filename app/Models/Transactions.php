<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'category_id',
        'type',
        'amount',
        'date_input',
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }

}
