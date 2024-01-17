<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PostsController extends Controller
{
    public function index()
    {
        $latestPosts = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                'users.id as author_id',
                'users.name as author_name',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ])
            ->latest()
            ->paginate(10);
        return view('front-end.home', compact('latestPosts'));
    }

    public function singlePost(Post $post)
    {
        return view('front-end.single-post', compact('post'));
    }

    public function postsByPostCategory(PostType $post_type, PostCategory $post_category = null)
    {
        $postType = $post_type;
        $postCategories = $postType->post_categories;
        $selectedCategory = $post_category ?: $postCategories->first();
        $postsQuery = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->groupBy('posts.id')
            ->where('posts.post_category_id', $selectedCategory->id);
        $posts = $postsQuery->select([
            'posts.*',
            'post_categories.name as post_category',
            'post_categories.slug as post_category_slug',
            'users.id as author_id',
            'users.name as author_name',
            'users.avatar as author_avatar',
            DB::raw('COUNT(post_comments.id) as comments'),
            DB::raw('COUNT(post_likes.customer_id) as likes')
        ])
        ->latest()
        ->paginate(10);
        return view('front-end.post-type-template', compact('posts', 'postType', 'postCategories', 'selectedCategory', 'selectedCategory'));
    }
}
