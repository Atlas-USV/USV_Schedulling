<?php

namespace App\Rules;

use Closure;
use App\Models\Group;
use App\Models\Speciality;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Validation\ValidationRule;

class FacultySpecialityGroupRule implements ValidationRule
{

    protected $facultyId;
    protected $roleId;
    protected $groupId;
    protected $specialityId;
    /**
     * Constructor to initialize the faculty_id and role_id values.
     *
     * @param  int  $facultyId
     * @param  int  $roleId
     */
    public function __construct($facultyId, $roleId, $groupId, $specialityId)
    {
        $this->facultyId = $facultyId;
        $this->roleId = $roleId;
        $this->$groupId = $groupId;
        $this->specialityId = $specialityId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If no role is provided, ensure no fields are assigned
        if ($this->roleId == null) {
            if ($this->facultyId != null || $this->specialityId != null || $this->groupId != null) {
                $fail('A user without a role cannot have any associated fields.');
            }
            return;
        }
    
        // Find the role by ID
        $role = Role::find($this->roleId);
    
        // If the role is not found, fail the validation
        if ($role == null) {
            $fail('Invalid role.');
            return;
        }
    
        // Logic for secretary and teacher roles
        if ($role->name == 'secretary' || $role->name == 'teacher') {
            if ($this->facultyId == null) {
                $fail("A $role->name must be assigned to a faculty.");
                return;
            }
            if ($this->specialityId != null || $this->groupId != null) {
                $fail("A $role->name cannot have speciality or group assigned.");
            }
            return;
        }
    
        // Logic for student role
        if ($role->name == 'student') {
            if ($this->facultyId != null) {
                $fail('A student cannot be assigned to a faculty.');
                return;
            }
            if ($this->specialityId != null && $this->groupId != null) {
                $fail('A student cannot have both speciality and group assigned.');
                return;
            }
            if ($this->groupId != null) {
                $group = Group::find($this->groupId);
                if ($group == null) {
                    $fail('Invalid group.');
                    return;
                }
                if ($this->specialityId != null) {
                    $fail('A student assigned to a group cannot have a speciality.');
                }
            }
            return;
        }
    
        // If the role is not recognized, fail validation
        $fail("The role '$role->name' is not supported.");
    }
    
}
