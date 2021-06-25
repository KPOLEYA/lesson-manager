<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    public function students() {
        return $this->hasMany(Student::class, 'parents_id', 'id');
    }
}
