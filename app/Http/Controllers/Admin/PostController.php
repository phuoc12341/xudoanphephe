<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $postService;
    protected $categoryService;
    protected $tagService;

    public function __construct(PostService $postService, CategoryService $categoryService, TagService $tagService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = $this->postService->paginateList(['*'], 'order', 'asc');
        $posts = $this->postService->fetchAll();
        $categories = $this->categoryService->fetchAll(['id', 'name', 'status']);

        $data = [
            'posts' => $posts,
            'categories' => $categories,
        ];

        return view('admin.posts.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->fetchAll(['id', 'name', 'status']);
        $tags = $this->tagService->fetchAll(['id', 'name']);

        $data = [
            'categories' => $categories,
            'tags' => $tags,
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only('category_id', 'order', 'title', 'tags', 'slug', 'description', 'image');
        if (array_key_exists('image', $params) && $params['image']->isValid()) {
            $fileName = $params['image']->hashName();
            $params['image']->storeAs('images', $fileName);
            $params['image'] = $fileName;
        } else {
            $params['image'] = null;
        }
        // dd($params['order']);
        $data = [
            // 'user_id' => 1,
            'title' => $params['title'],
            'category_id' => $params['category_id'],
            'slug' => Str::of($params['title'])->slug('-'),
            'status' => Post::ACTIVE,
            'description' => $params['description'],
            'image' => $params['image'],
            'order' => $params['order'],
            'view' => 0,
        ];

        $post = $this->postService->store($data);
        if (!$post) {
            return back();
        }

        $post->tags()->attach($params['tags'] ?? []);
        
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        $menus = Menu::whereNull('parent_id')->where('root_id', 1)->get();
        
        $post = $this->postService->findById($id);

        $data = [
            'post' => $post,
            'menus' => $menus,
        ];

        return view('web.post-detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $post = $this->postService->findById($id);
        if (!$post) {
            return back();
        }
        
        $postTags = $post->tags->pluck('id');
        $categories = $this->categoryService->fetchAll(['id', 'name', 'status']);
        $tags = $this->tagService->fetchAll(['id', 'name']);
        $data = [
            'categories' => $categories,
            'tags' => $tags,
            'post' => $post,
            'postTags' => $postTags,
        ];
        
        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $params = $request->only('category_id', 'order', 'title', 'tags', 'slug', 'description', 'image', 'is_delete_image');

        $post = $this->postService->findById($id);

        if (!$post) {
            return back();
        }

        $data = [
            'category_id' => $params['category_id'],
            'title' => $params['title'],
            'slug' => Str::of($params['title'])->slug('-'),
            'status' => Post::ACTIVE,
            'description' => $params['description'],
            'order' => $params['order'],
        ];

        if (array_key_exists('image', $params) && $params['image']->isValid()) {
            $fileName = $params['image']->hashName();
            $params['image']->storeAs('images', $fileName);
            $params['image'] = $fileName;

            $data['image'] = $params['image'];

            Storage::delete("images/{$post->image}");
        } elseif ((bool)$params['is_delete_image']) {
            Storage::delete("images/{$post->image}");
            $data['image'] = null;
        }

        $result = $this->postService->update($id, $data);

        if (!$result) {
            return back();
        }

        $post->tags()->sync($params['tags'] ?? []);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->postService->deleteById($id);
        if ($result == false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    public function switchStatus(Request $request)
    {
        $params = $request->only('id', 'status');
        $data = [
            'status' => $params['status'],
        ];

        $result = $this->postService->update($params['id'], $data);

        if ($result === false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    public function updateOrder(Request $request)
    {
        $params = $request->only('id', 'order');
        $post = $this->postService->findById($params['id']);

        $currentOrder = $post->order;

        $orderParam = $this->reIndexOrder($params['order'], $currentOrder);

        $data = [
            'order' => $orderParam,
        ];

        $result = $this->postService->update($params['id'], $data);

        if ($result === false) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([], Response::HTTP_OK);
    }

    private function reIndexOrder(int $orderParam = null, int $currentOrder = null)
    {
        $maxOrder = Post::max('order');
        // dd($maxOrder, ++$maxOrder);
        if (is_null($maxOrder)) {
            return 1;
        }

        if (is_null($orderParam)) {
            $this->postService->getModel()->where('order', '>', $currentOrder)->decrement('order');

            return $orderParam;
        }

        if ($orderParam > $maxOrder) {
            if (is_null($currentOrder)) {
                return ++$maxOrder;
            }

            $this->postService->getModel()->where('order', '>', $currentOrder)->decrement('order');

            return $maxOrder;
        }
        
        if ($orderParam <= $maxOrder) {
            if (is_null($currentOrder)) {
                $this->postService->getModel()->where('order', '>=', $orderParam)->increment('order');

                return $orderParam;
            }

            $this->postService->getModel()->where('order', '>=', $orderParam)->where('order', '<', $currentOrder)->increment('order');

            return $orderParam;
        }


        return $orderParam > $maxOrder ? ++$maxOrder : $orderParam;
    }
}
