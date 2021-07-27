<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->fetchAll(['id', 'name', 'status']);

        $data = [
            'categories' => $categories,
        ];

        return view('admin.categories.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateCategoryRequest $request)
    {
        $params = $request->only('name', 'parent_id');
        $data = [
            'name' => $params['name'],
            'parent_id' => $params['parent_id'],
            'slug' => Str::of($params['name'])->slug('-'),
            'status' => Category::ACTIVE,
        ];

        $result = $this->categoryService->insert($data);

        if ($result === false) {
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryService->findById($id, ['id', 'name', 'parent_id']);

        if ($category === null) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        $listCategoryCanBeParent = $this->categoryService->getCategoriesCanBeParent($id);

        return (new CategoryResource($category))
            ->additional(
                [
                    'data' => [
                        'parent_id' => $category->parent_id,
                        'categoriesCanBeParent' => collect($listCategoryCanBeParent)->pluck('id')->toArray(),
                    ]
                ]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateCategoryRequest $request, int $id)
    {
        $params = $request->only('name', 'parent_id');
        $result = $this->categoryService->update($id, $params);

        if ($result === 0) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = $this->categoryService->checkCategoryCanDelete($id);

        if ($category === null) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->categoryService->deleteById($category->id);

        return response()->json([], Response::HTTP_OK);
    }

    public function getAllCategory(Request $request)
    {
        $listAllCategory = $this->categoryService->fetchAll(['id', 'name']);

        return CategoryResource::collection($listAllCategory);
    }

    public function switchStatus(Request $request)
    {
        $params = $request->only('id', 'status');
        $this->categoryService->switchCategoryStatus($params['id'], $params['status']);

        return response()->json([], Response::HTTP_OK);
    }
}
