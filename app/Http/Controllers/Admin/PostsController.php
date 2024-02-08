<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateCategory;
use App\Http\Requests\UpdateOrCreatePost;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostType;
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
        $postsQuery = Post::join('categories', 'categories.id', '=', 'posts.post_category_id')
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
            return view('posts.create', compact('postTypes', 'postCategories', 'postStatuses'));
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
        flashSuccessMessage('Post created successfully - Title:' . $post->title);
        return redirect()->route('admin.post.update', $post);
    }

    public function update(UpdateOrCreatePost $request, Post $post)
    {
        if(request()->isMethod('GET')){
            $postTypes = PostType::all();
            $postCategories = Category::all();
            $postStatuses = PostStatus::cases();
            return view('posts.edit', compact('postTypes', 'postCategories', 'postStatuses', 'post'));
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
        flashSuccessMessage('Post updated successfully - Title:' . $post->title);
        return redirect()->route('admin.post.update', $post);
    }

    public function preview(Post $post)
    {
        return view('front-end.single-post', compact('post'));
    }

    public function delete(Post $post)
    {
        $postTitle = $post->title;
        $post->delete();
        flashSuccessMessage("Post {$postTitle} Deleted Successfully}");
        return back();
    }

    public function categories()
    {
        $postCategories = Category::all();
        $postTypes = PostType::all();
        return view('posts.list-categories', compact('postCategories', 'postTypes'));
    }

    public function saveCategory(UpdateOrCreateCategory $request)
    {
        $categorySlug = Str::slug($request->get('name'));
        $navigationIcon = null;
        if($request->navigation_icon) {
            $navigationIcon = uploadFilesFromRequest($request, 'navigation_icon', 'categories-navigation-icon', strtolower("{$categorySlug}_navigation_icon"));
        }
        $category = Category::create([
            'post_type_id' => $request->get('post_type'),
            'name' => $request->get('name'),
            'slug' => $categorySlug,
            'description' => $request->get('description'),
            'navigation_icon' => $navigationIcon
        ]);
        flashSuccessMessage("Category:'{$category->name}' created successfully.");
        return back();
    }

    public function updateCategory(UpdateOrCreateCategory $request, Category $category)
    {
        $categorySlug = Str::slug($request->get('edit_category_name'));
        $navigationIcon = null;
        if($request->edit_category_navigation_icon) {
            $navigationIcon = uploadFilesFromRequest($request, 'edit_category_navigation_icon', 'categories-navigation-icon', strtolower("{$categorySlug}_navigation_icon"));
        }
        $category->update([
            'post_type_id' => $request->edit_category_post_type,
            'name' => $request->edit_category_name,
            'slug' => Str::slug($request->edit_category_name),
            'description' => $request->edit_category_description,
            'navigation_icon' => $navigationIcon ?: $category->navigation_icon
        ]);
        flashSuccessMessage("Category:'{$category->name}' updated successfully.");
        return back();
    }

    public function deleteCategory(Category $category)
    {
        $categoryName = $category->name;
        $postsCount = $category->posts()->count();
        if($category->posts()->count() > 0){
            flashErrorMessage("Unable to delete category '{$categoryName}'; It is attached to {$postsCount} posts");
            return back();
        }
        $category->delete();
        flashSuccessMessage("Category:'{$categoryName}' updated successfully.");
        return back();
    }
}
