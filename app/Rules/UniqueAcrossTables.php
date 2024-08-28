<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueAcrossTables implements Rule
{
    protected $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function passes($attribute, $value)
    {
        // Check uniqueness across units, properties, and projects
        $existsInUnits = DB::table('units')->where($this->attribute, $value)->exists();
        $existsInProperties = DB::table('properties')->where($this->attribute, $value)->exists();
        $existsInProjects = DB::table('projects')->where($this->attribute, $value)->exists();

        return !$existsInUnits && !$existsInProperties && !$existsInProjects;
    }

    public function message()
    {
        return 'The :attribute has already been used before.';
    }
}
