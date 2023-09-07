<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model {
    protected $table = "taxes";
    public $timestamps = false;
    protected $primaryKey = 'tax_id';
    protected $fillable = ['id', 'name', 'tax'];

    public function uniqueIds(): array {
        return ['id'];
    }
}
