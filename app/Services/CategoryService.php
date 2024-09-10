<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService
{

    public function getCategories(Request $request)
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters('name')
            ->allowedIncludes('articles');

        return $categories->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function createCategory(StoreCategoryRequest $request): Category
    {
        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return $category;
    }

    public function updateCategory(UpdateCategoryRequest $request, Category $category): Category
    {
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return $category;
    }

    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }
}
