<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\PageService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    protected $menuService;
    protected $categoryService;
    protected $pageService;
    protected $postService;

    public function __construct(MenuService $menuService, CategoryService $categoryService, PageService $pageService, PostService $postService)
    {
        $this->menuService = $menuService;
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->menuService->getModel()->whereNull('root_id')->get();

        $data = [
            'menus' => $menus,
        ];

        return view('admin.menus.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->fetchAll();
        $pages = $this->pageService->fetchAll();
        $posts = $this->postService->fetchAll();

        $data = [
            'categories' => $categories,
            'pages' => $pages,
            'posts' => $posts,
        ];


        return view('admin.menus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only('name', 'table_content', 'active_top', 'active_footer');

        $rootMenuId = $this->menuService->insertGetId([
            'name' => $params['name'],
            'active_top' => $params['active_top'],
            'active_footer' => $params['active_footer'],
        ]);

        $parentMenus = $params['table_content'];
        
        $result = $this->menuService->insertMenu($parentMenus, $rootMenuId, $rootMenuId);

        if (!$result) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $menu = $this->menuService->findById($id);

        $menus = $menu->children()->get();
        // dd($menus);
        $categories = $this->categoryService->fetchAll();
        $pages = $this->pageService->fetchAll();
        $posts = $this->postService->fetchAll();

        $data = [
            'menu' => $menu,
            'categories' => $categories,
            'pages' => $pages,
            'posts' => $posts,
            'menus' => $menus,
        ];
        
        return view('admin.menus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $params = $request->only('name', 'table_content');

        $menu = $this->menuService->findById($id);

        if (!$menu) {
            return back();
        }

        $data = [
            'name' => $params['name'],
        ];

        $result = $this->menuService->update($id, $data);
        if (!$result) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->menuService->deleteMenuByid($id);
        if (!$result) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parentMenus = $params['table_content'];
        $result = $this->menuService->insertMenu($parentMenus, $id, $id);
        if (!$result) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->menuService->deleteMenuByid($id);
        if ($result == false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }
}
