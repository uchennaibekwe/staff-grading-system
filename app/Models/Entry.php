<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'department_id',
        'punctuality',
        'professionalism',
        'innovation',
        'respect',
        'communication',
        'management',
        'leadership',
        'delivery',
        'inclusiveness',
        'appearance'
    ];

    public $appends = ['percentage'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function department() {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function getAverageAttribute() {
        return $this->total / 10;
    }

    public function getPercentageAttribute() {
        return $this->attributes['percentage'] = ($this->total / 50 ) * 100;
    }

    public function getGradeAttribute() {
        return $this->computeGrade($this->percentage);
    }

    public function computeGrade($average) {
        if ($average >= 80)
            return 'A';
        else if ($average >= 65)
            return 'B';
        else if ($average >= 55)
            return 'c';
        else if ($average >= 40)
            return 'D';
        else if ($average >= 30)
            return 'E';
        else 
            return 'F';
    }
}
