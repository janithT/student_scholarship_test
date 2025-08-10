<?php

namespace App\Repositories;

use App\Models\Scholarship;

class ScholarsRepository
{
    /**
     * Create user 
     * 
     */
    public function getAll()
    {
        return Scholarship::get();
    }


    /**
     * Create user 
     * 
     */
    public function create(array $data)
    {
        return Scholarship::firstOrCreate(
            ['title' => $data['title']],
            [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'] ?? true,
                'deadline'    => $data['deadline'],

            ]
        );
    }

    public function update(array $data, int $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($data);
        return $scholarship;
    }


    public function delete(int $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return $scholarship->delete();
    }

}