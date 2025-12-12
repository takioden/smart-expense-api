<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepo
    ) {}

    private function validate(array $data, bool $isUpdate = false)
    {
        $rules = [
            'name' => $isUpdate ? 'sometimes|string' : 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function getAll(int $userId)
    {
        return $this->categoryRepo->getAllByUser($userId);
    }

    public function create(int $userId, array $data)
    {
        $this->validate($data);

        $data['user_id'] = $userId;

        return $this->categoryRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        $category = $this->categoryRepo->findById($id);

        $this->validate($data, true);

        return $this->categoryRepo->update($category, $data);
    }

    public function delete(int $id)
    {
        $category = $this->categoryRepo->findById($id);
        return $this->categoryRepo->delete($category);
    }
}
