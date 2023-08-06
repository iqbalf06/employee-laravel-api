<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $rules = [
        'gender' => 'in:Male,Female',
        'department' => 'in:HR,Finance,IT,Legal,Customer Service,Administrator'
    ];

    public function save(array $options = [])
    {
        $this->attributes['department'] = $this->department;
        $this->attributes['gender'] = $this->gender;

        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Invalid gender or department value.');
        }

        parent::save($options);

        return true;
    }
}
