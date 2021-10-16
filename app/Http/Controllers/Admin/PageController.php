<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageService->fetchAll();

        $data = [
            'pages' => $pages,
        ];

        return view('admin.pages.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only('title', 'slug', 'description');

        $data = [
            'title' => $params['title'],
            'slug' => Str::of($params['title'])->slug('-'),
            'description' => $params['description'],
        ];

        $page = $this->pageService->store($data);
        if (!$page) {
            return back();
        }
        
        return redirect()->route('admin.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $topMenu = Menu::whereNull('parent_id')->where('active_top', Menu::TOP_MENU)->first();
        $page = $this->pageService->findBySlug($slug);

        $data = [
            'page' => $page,
            'topMenu' => $topMenu,
        ];

        return view('web.page', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $page = $this->pageService->findById($id);
        if (!$page) {
            return back();
        }
        
        $data = [
            'page' => $page,
        ];
        
        return view('admin.pages.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $params = $request->only('title', 'slug', 'description');

        $page = $this->pageService->findById($id);

        if (!$page) {
            return back();
        }

        $data = [
            'title' => $params['title'],
            'slug' => Str::of($params['title'])->slug('-'),
            'description' => $params['description'],
        ];

        $result = $this->pageService->update($id, $data);

        if (!$result) {
            return back();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->pageService->deleteById($id);
        if ($result == false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }
}
