<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
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
            ->join('post_types', 'post_types.id', '=', 'post_categories.post_type_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.id) as likes')
            ])
            ->latest()
            ->paginate(10);
        return view('front-end.home', compact('latestPosts', 'recordsPerPage'));
    }

    public function singlePost(Post $post)
    {
        return view('front-end.single-post', $post);
    }
}
