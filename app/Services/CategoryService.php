<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService
{
    private const DEFAULT_PER_PAGE = 10;

    public function getCategories(Request $request)
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters('name')
            ->allowedIncludes('articles');

        return $categories->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
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
