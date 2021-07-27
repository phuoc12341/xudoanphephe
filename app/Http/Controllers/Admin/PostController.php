<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

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
        $posts = $this->postService->fetchAll();

        $data = [
            'posts' => $posts,
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
        $params = $request->only('category_id', 'title', 'tags', 'slug', 'description', 'image');
        if (array_key_exists('image', $params) && $params['image']->isValid()) {
            $fileName = $params['image']->hashName();
            $params['image']->storeAs('images', $fileName);
            $params['image'] = $fileName;
        } else {
            $params['image'] = null;
        }

        $data = [
            'user_id' => 1,
            'title' => $params['title'],
            'category_id' => $params['category_id'],
            'slug' => Str::of($params['title'])->slug('-'),
            'status' => Post::ACTIVE,
            'description' => $params['description'],
            'image' => $params['image'],
            'view' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
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
    public function show(Post $post)
    {
        //
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
        $params = $request->only('category_id', 'title', 'tags', 'slug', 'description', 'image', 'is_delete_image');

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
}
