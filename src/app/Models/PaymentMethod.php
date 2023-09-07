<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    protected $table = "payment_methods";
    public $timestamps = false;
    protected $primaryKey = 'intern_id';
    protected $fillable = ['id', 'name', 'tax'];

    public function uniqueIds(): array {
        return ['id'];
    }
}
