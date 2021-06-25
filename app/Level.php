<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    const LEVEL_SIXTH_ID = 1;
    const LEVEL_FIFTH_ID = 2;
    const LEVEL_FOURTH_ID = 3;
    const LEVEL_THIRD_ID = 4;
    const LEVEL_SECOND_ID = 5;
    const LEVEL_FIRST_ID = 6;
    const LEVEL_TERMINAL_ID = 7;

    const LEVEL_SIXTH = "Sixième";
    const LEVEL_FIFTH = "Cinquième";
    const LEVEL_FOURTH = "Quatrième";
    const LEVEL_THIRD = "Troisième";
    const LEVEL_SECOND = "Seconde";
    const LEVEL_FIRST = "Première";
    const LEVEL_TERMINAL = "Terminale";


    public function students() {
        return $this->hasMany(Student::class, 'level_id', 'id');
    }
}
