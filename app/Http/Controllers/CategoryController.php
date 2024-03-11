<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(Category::class)
            ->allowedFilters('name')
            ->allowedIncludes('articles');

        return response()->json(CategoryResource::collection($query->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($category, Request $request)
    {
        $category = Category::Where('id', $category)
            ->orWhere('name', $category)
            ->firstOrFail();

        $category->load([
            'articles' => function ($query) use ($request) {

                $query->orderBy('created_at', 'desc');

                if ($request->user()->hasRole('reader')) {
                    $query->where('status', 'published');
                }

                if ($request->has('limit') && is_numeric($request->limit) && $request->limit > 0) {
                    $query->limit($request->limit);
                }

                $query->with(['file', 'category', 'municipality.department']);
            },
        ]);

        return response()->json(new CategoryResource($category));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
