<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $postService;
    protected $categoryService;
    protected $tagService;
    protected $menuService;

    public function __construct(PostService $postService, CategoryService $categoryService, TagService $tagService, MenuService $menuService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->menuService = $menuService;
    }
    
    public function index()
    {
        // dd(45435);
        // $test = Menu::find(5);

        // dd($test->menuable->link);

        // $topMenu = Menu::whereNull('parent_id')->where('active_top', Menu::TOP_MENU)->first();
        // dd($topMenus);
        // $featurePost = $this->postService->getModel()->where('order', '<=', 4)->orderBy('order')->get();
        // $categories = $this->categoryService->getModel()->where('order', '<=', 3)->orderBy('order')->get();
        // $popularPosts = $this->postService->getModel()->orderBy('view')->limit(5)->get();
        // $latestPosts = $this->postService->getModel()->orderBy('updated_at')->limit(6)->get();
        // $footerMenu = $this->menuService->getModel()->whereNull('parent_id')->where('active_footer', Menu::FOOTER_MENU)->first();
        // dd($topMenu);
        // dd($footerMenu->child);
        // dd($latestPosts->first()->updated_at);
        $data = [
            // 'featurePost' => $featurePost,
            // 'topMenu' => $topMenu,
            // 'categories' => $categories,
            // 'popularPosts' => $popularPosts,
            // 'latestPosts' => $latestPosts,
            // 'footerMenu' => $footerMenu,
        ];

        return view('web.home', $data);
    }

    public function alo(Request $request)
    {
        if (preg_match('~[0-9]+~', $request->message)) {
            $numberMessages = explode(" ", $request->message);

            $convert = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

            $messages = [];
            foreach ($numberMessages as $key => $value) {
                if (is_numeric($value)) {
                    $value--;
                    $messages[] = $convert[$value];
                }
            }
            
            $messages = (implode('', $messages));
        } else {
            $messages = strtoupper($request->message);
        }
        
        $messages = str_split($messages);
        $alphas = range('A', 'Z');

        $changeTableArr = range('A', 'Z');

        $result = [];
        foreach ($alphas as $alpha) {
            array_push($changeTableArr, array_shift($changeTableArr));
            $newChangeTable = array_combine($changeTableArr, $alphas);

            $test = [];
            foreach ($messages as $key => $value) {
                if (isset($newChangeTable[$value])) {
                    $test[] = $newChangeTable[$value];
                } else {
                    $test[] = $value;
                }
            }

            $test = implode('', $test);
            $result[] = $test;
        }

        return view('alo', ['messages' => $result]);
    }

    public function showCategory(Request $request)
    {
        # code...
    }
}
