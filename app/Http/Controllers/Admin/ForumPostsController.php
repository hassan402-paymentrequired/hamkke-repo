<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForumPostsController extends Controller
{
    public function index()
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
}
