<?php

namespace App\Repositories;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationRepository
{
    /**
     * Get all applications.
     * 
     */
    public function getMyApps(int $userId)
    {
        return Application::where('user_id', $userId)
            ->with('scholarship:id,title,description')
            ->get(['id', 'scholarship_id', 'status']);
    }


    public function getById(int $userId)
    {
        return Application::where('user_id', $userId)
            ->with('scholarship:id,title,description')
            ->first(['id', 'user_id', 'scholarship_id', 'status', 'remarks']);
    }


    /**
     * Create application. 
     * 
     */
    public function create(array $data)
    {
        $user_id = Auth::user()->id;
        // If user_id is not in the data, use the authenticated user's ID
        if ($data['user_id'] != $user_id) {
            throw new \InvalidArgumentException('You are not allowed to do that.');
        }

        $userId = $data['user_id'] ?? $user_id;

        return Application::firstOrCreate(
            ['user_id' => $userId, 'scholarship_id' => $data['scholarship_id']],
            [
                'user_id' => $userId,
                'scholarship_id' => $data['scholarship_id'] ?? null,
                'status'      => $data['status'] ?? true,
                'remarks'    => $data['remarks'],
            ]
        );
    }

    /**
     * Update an existing application.
     */
    public function update(array $data, int $id)
    {
        $scholarship = Application::findOrFail($id);
        $scholarship->update($data);
        return $scholarship;
    }


    /**
     * Delete an application.
     */
    public function delete(int $id)
    {
        $scholarship = Application::findOrFail($id);
        return $scholarship->delete();
    }
}
