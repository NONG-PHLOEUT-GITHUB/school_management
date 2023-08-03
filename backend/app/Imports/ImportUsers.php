<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator;

class ImportUsers implements ToModel,WithHeadingRow
{
    // protected $imported = 0;
    protected $skipped = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('email', '=', $row['email'] ?? $row['Email'] ?? $row['email'])->first();
        if ($user) {
            // If a user with the email already exists, delete the email and return null
            unset($row['email'], $row['Email']);
            return null;
        } else {
            // Otherwise, create a new user
            $user = new User([
                'first_name'=> $row['first_name'] ?? $row['First name'] ?? $row['first name'],
                'last_name'=> $row['last_name'] ?? $row['Last name'] ?? $row['last name'],
                'email'=> $row['email'] ?? $row['Email'] ?? $row['email'],
                'gender'=> $row['gender'] ?? $row['Gender'] ?? $row['gender'],
                'age'=> $row['age'] ?? $row['Age'] ?? $row['age'],
                'date_of_birth'=> date('Y-m-d H:i:s', strtotime($row['date_of_birth'] ?? $row['Date of birth'] ?? $row['date of birth'])),
                'phone_number'=> $row['phone_number'] ?? $row['Phone number'] ?? $row['phone number'],
                'address'=> $row['address'] ?? $row['Address'] ?? $row['address'],
                'password' => Hash::make($row['password'] ?? $row['Password']),
                'profile'=>$row['profile'] ?? $row['Profile'],
                'role'=> 3,
            ]);
            $user->save();
        }
    }
}
