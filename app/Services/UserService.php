<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function create(array $data)
    {
        $this->validateUser($data, false);

        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \Exception("User tidak ditemukan");
        }

        $this->validateUser($data, true);

        return $this->userRepository->update($user, $data);
    }

    public function delete(int $id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \Exception("User tidak ditemukan");
        }

        return $this->userRepository->delete($user);
    }

    private function validateUser(array $data, bool $isUpdate)
    {
        $rules = [
            'name' => 'required|string',
            'email' => $isUpdate
                ? 'sometimes|email'
                : 'required|email|unique:users,email',
            'password' => $isUpdate
                ? 'sometimes|min:3'
                : 'required|min:3',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
