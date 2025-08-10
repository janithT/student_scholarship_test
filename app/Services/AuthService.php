<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(private UserRepository $userRepo) {}


    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function studentRegister(array $data): object
    {

        try {
            DB::beginTransaction();

            $user = $this->userRepo->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Assign role via Spatie
            $user->assignRole('Student');

            // send email for student welcome email.
            $emailPayload = [
                'to'       => $user->email,
                'subject'  => 'Welcome to scholarship App',
                'template' => 'emails.welcome',
                'name'     =>  $user->name,
            ];
            sendSystemEmail($emailPayload);
            DB::commit();

            return apiServiceResponse($user, true, 'Student registered successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return apiServiceResponse([], false, $e->getMessage());
        }
    }


    /**
     * User login.
     *
     * @param array $data
     * @return User
     */
    public function studentLogin(array $data): object
    {
        try {
            $user = $this->userRepo->findByEmail($data['email']);

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new \Exception('Invalid credentials');
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->sanc_token = $token;

            return apiServiceResponse($user, true, 'Student logged in successfully');
        } catch (\Throwable $e) {
            return apiServiceResponse([], false, $e->getMessage());
        }
    }
}
