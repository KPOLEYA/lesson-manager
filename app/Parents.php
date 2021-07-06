<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname', 'phone', 'email'
    ];

    public function students() {
        return $this->hasMany(Student::class, 'parents_id', 'id');
    }
}
