<?php

namespace App\Imports;

use App\Jobs\SendEmailJob;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public School $school;
    public function __construct(School $school)
    {
        //
        $this->school = $school;
    }
    public function model(array $row)
    {
        $user = User::where('email', $row['email'])->where('user_name', $row['user_name'])->where('contact', $row['contact'])->get();
        if ($user->count() > 0) {
            $userId = $user[0]->id;
            if (Teacher::where('user_id', $userId)->where('school_id', $this->school->id)->count() == 0) {
                # code...
                $teacher = new Teacher([
                    'school_id' => $this->school->id,
                    'user_id' => $userId,
                ]);
                $email = $row['email'];
                $schoolName = $this->school->name;
                $body = "Your teacher account has been created successfully in the school $schoolName";
                $subject = "Teacher Account";
                $name = $row['name'];
                SendEmailJob::dispatch($subject, $body, $email, $name);

                return $teacher;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
