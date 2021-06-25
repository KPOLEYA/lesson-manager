<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname', 'email'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    protected $appends = [
        'complete_name'
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const STATUTES = [
        ['id' => self::STATUS_INACTIVE, 'text' => "Inactif"],
        ['id' => self::STATUS_ACTIVE, 'text' => "Actif"],
    ];

    /**
     * Getter for complete_name - dynamic append
     */
    public function getCompleteNameAttribute() {
        return $this->name . ' ' . $this->firstname;
    }

    public function level() {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function parents() {
        return $this->belongsTo(Parents::class, 'parents_id', 'id');
    }
}
