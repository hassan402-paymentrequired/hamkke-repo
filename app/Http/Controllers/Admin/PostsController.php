<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateCategory;
use App\Http\Requests\UpdateOrCreatePost;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostType;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $postTypes = PostType::all();
        $postCategories = Category::all();
        $postStatuses = PostStatus::cases();
        $postsQuery = Post::withoutGlobalScopes()->join('categories', 'categories.id', '=', 'posts.post_category_id')
                ->join('post_types', 'post_types.id', '=', 'categories.post_type_id')
                ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
                ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id');
        if($request->post_type) {
            $postsQuery->where('post_types.id', $request->post_type);
        }
        if($request->post_category){
            $postsQuery->where('categories.id', $request->post_category);
        }
        if($request->post_status){
            $postsQuery->where('posts.post_status_id', $request->post_status);
        }
        $posts = $postsQuery->groupBy('posts.id')
            ->select([
                'posts.*',
                'categories.name as post_category',
                'categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.post_id) as likes')
            ])->paginate(20);
        return view('posts.list', compact('postTypes', 'postCategories', 'postStatuses', 'posts'));
    }

    public function create(UpdateOrCreatePost $request)
    {
        if(request()->isMethod('GET')){
            $postTypes = PostType::all();
            $postCategories = Category::all();
            $postStatuses = PostStatus::cases();
            $tags = Tag::all();
            return view('posts.create', compact('postTypes', 'postCategories', 'postStatuses', 'tags'));
        }
        $request->merge(request()->all());
        $validatedData = $request->all();
        $postSlug = Str::slug($validatedData['post_title']);
        $featuredImage = null;
        if($request->featured_image) {
            $featuredImage = uploadFilesFromRequest(
                $request, 'featured_image', 'features-images',
                strtolower("{$postSlug}_featured_image")
            );
        }
        $post = Post::create([
            'title' => $validatedData['post_title'],
            'slug' => $postSlug,
            'post_category_id' => $validatedData['post_category'],
            'summary' => $validatedData['post_summary'],
            'body' => $validatedData['post_content'],
            'post_status_id' => PostStatus::DRAFT,
            'post_author' => auth()->id(),
            'featured_image' => $featuredImage
        ]);
        $requestPostTags = $request->get('post_tags');
        if(!empty($requestPostTags)){
            foreach ($requestPostTags as $tagId) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tagId
                ]);
            }
        }
        flashSuccessMessage('Post created successfully - Title:' . $post->title);
        return redirect()->route('admin.post.update', $post);
    }

    public function update(UpdateOrCreatePost $request, Post $post)
    {
        if(request()->isMethod('GET')){
            $postTypes = PostType::all();
            $postCategories = Category::all();
            $postStatuses = PostStatus::cases();
            $tags = Tag::all();
            $postTags = $post->tags;
            return view('posts.edit', compact('postTypes', 'postCategories', 'postStatuses', 'post', 'tags', 'postTags'));
        }
        $postSlug = Str::slug($request->get('post_title'));
        $featuredImage = null;
        if($request->featured_image) {
            $featuredImage = uploadFilesFromRequest($request, 'featured_image', 'features-images', strtolower("{$postSlug}_featured_image"));
        }
        $post->update([
            'title' => $request->get('post_title'),
            'slug' => Str::slug($request->get('post_title')),
            'post_category_id' => $request->get('post_category'),
            'summary' => $request->get('post_summary'),
            'body' => $request->get('post_content'),
            'post_status_id' => $request->get('post_status'),
            'featured_image' => $featuredImage ?: $post->featured_image
        ]);
        $requestPostTags = $request->get('post_tags');
        if(!empty($requestPostTags)){
            foreach ($requestPostTags as $tagId) {
                PostTag::firstOrCreate([
                    'post_id' => $post->id,
                    'tag_id' => $tagId
                ]);
            }
        }
        flashSuccessMessage('Post updated successfully - Title:' . $post->title);
        return redirect()->route('admin.post.update', $post);
    }

    public function preview(Post $post)
    {
        return (new \App\Http\Controllers\Front\PostsController())->singlePost($post);
    }

    public function delete(Post $post)
    {
        $postTitle = $post->title;
        $post->delete();
        flashSuccessMessage("Post {$postTitle} Deleted Successfully}");
        return back();
    }

//    public function preview(Post $post){
//        return (new \App\Http\Controllers\Front\PostsController())->singlePost($post);
//    }
}
