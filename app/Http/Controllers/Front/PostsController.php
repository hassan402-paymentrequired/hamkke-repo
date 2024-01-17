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
        $latestPosts = Post::withCategoryCommentsAndLikes()
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
        $postAuthor = $post->author;
        $postComments = $post->comments()->leftJoin('customers', 'customers.id', 'post_comments.customer_id')
            ->select([
                'post_comments.*',
                'customer.name as customer_name',
                'customer.username as customer_usernames'
            ]);
        $postCategory = $post->post_category;
        $relatedPosts = Post::withCategoryCommentsAndLikes()
            ->where('posts.id', '!=', $post->id)
            ->where(function ($q) use ($postCategory) {
                $q->where('post_categories.id', $postCategory->id)
                    ->orWhere('post_types.id', $postCategory->post_type_id);
            })
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
            ->limit(3)->get();
        return view('front-end.single-post', compact('post', 'postComments', 'postAuthor', 'relatedPosts'));
    }

    public function postsByPostCategory(PostType $post_type, PostCategory $post_category = null)
    {
        $postType = $post_type;
        $postCategories = $postType->post_categories;
        $selectedCategory = $post_category;
        $postsQuery = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->where('post_categories.post_type_id', $postType->id);
        if($selectedCategory) {
            $postsQuery->where('posts.post_category_id', $selectedCategory->id);
        }
        $posts = $postsQuery->groupBy('posts.id')->select([
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
