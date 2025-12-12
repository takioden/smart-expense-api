<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        $userId = auth()->id();
        return response()->json($this->categoryService->getAll($userId));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $category = $this->categoryService->create($userId, $request->all());

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->update($id, $request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return response()->json(['message' => 'Deleted']);
    }
}
