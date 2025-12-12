<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAllByUser(int $userId)
    {
        return Category::where('user_id', $userId)->get();
    }

    public function findById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
