<?php

namespace App\Imports;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $userEmail = User::pluck('email')->toArray();
        $userContact = User::pluck('contact')->toArray();
        $userUsername = User::pluck('user_name')->toArray();

        if (!in_array($row['user_name'], $userUsername) && !in_array($row['contact'], $userContact) && !in_array($row['email'], $userEmail)) {
            # code...
            $user = new User([
                'name' => $row['name'],
                'email' => $row['email'],
                'user_name' => $row['user_name'],
                'role_id' => 2,
                'country_id' => 1,
                'password' => Hash::make($row['password']),
                'contact' => $row['contact'],
            ]);
            $email = $row['email'];
            $password = $row['password'];
            $body = "Your user account has been created successfully!! your credentials are  __ Email: $email __ Password: $password";
            $subject = "User Account";
            $name = $row['name'];
            SendEmailJob::dispatch($subject, $body, $email, $name);

            return $user;
        }else{
            return null;
        }
    }
}
