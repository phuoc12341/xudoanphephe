<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Menu;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $postService;

    public function __construct(CategoryService $categoryService, PostService $postService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categories = $this->categoryService->getAdminCategories();
        $categories = $this->categoryService->getModel()->whereNull('parent_id')->get();

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
    public function show(Request $request, $slug, $id)
    {
        $topMenu = Menu::whereNull('parent_id')->where('active_top', Menu::TOP_MENU)->first();
        
        $category = $this->categoryService->findById($id);

        $parentAndRecursiveCategoryIds = $this->categoryService->getParentAndRecursiveChildIds($id);
        $featureCategoriesPosts = $this->postService->getFeatureCategoriesPosts($parentAndRecursiveCategoryIds);
        $posts = $this->postService->getCategoryPostsWithoutFeature($parentAndRecursiveCategoryIds);
        $popularPosts = $this->postService->getCategoryPopularPosts($parentAndRecursiveCategoryIds);
        // dd($popularPosts);

        $window = UrlWindow::make($posts);
        // dd($window);

        $elements = array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);

        // dd($test);
        
        $data = [
            'category' => $category,
            'featurePosts' => $featureCategoriesPosts,
            'topMenu' => $topMenu,
            'posts' => $posts,
            'elements' => $elements,
            'popularPosts' => $popularPosts,
        ];

        return view('web.category-detail', $data);
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

    public function updateOrder(Request $request)
    {
        $params = $request->only('id', 'order');
        $category = $this->categoryService->findById($params['id']);
        $currentOrder = $category->order;
        
        $orderParam = $this->reIndexOrder($params['order'], $currentOrder);

        $data = [
            'order' => $orderParam,
        ];

        $result = $this->categoryService->update($params['id'], $data);

        if ($result === false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    private function reIndexOrder(int $orderParam = null, int $currentOrder = null)
    {
        $maxOrder = Category::max('order');
        // dd($maxOrder, ++$maxOrder);
        if (is_null($maxOrder)) {
            return 1;
        }

        if (is_null($orderParam)) {
            $this->categoryService->getModel()->where('order', '>', $currentOrder)->decrement('order');

            return $orderParam;
        }

        if ($orderParam > $maxOrder) {
            if (is_null($currentOrder)) {
                return ++$maxOrder;
            }

            $this->categoryService->getModel()->where('order', '>', $currentOrder)->decrement('order');

            return $maxOrder;
        }
        
        if ($orderParam <= $maxOrder) {
            if (is_null($currentOrder)) {
                $this->categoryService->getModel()->where('order', '>=', $orderParam)->increment('order');

                return $orderParam;
            }

            $this->categoryService->getModel()->where('order', '>=', $orderParam)->where('order', '<', $currentOrder)->increment('order');

            return $orderParam;
        }


        return $orderParam > $maxOrder ? ++$maxOrder : $orderParam;
    }
}
