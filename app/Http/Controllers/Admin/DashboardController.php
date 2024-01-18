<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function home()
    {
        $cardStats = [
            'posts_count' => Post::where('post_status_id', PostStatus::PUBLISHED)->count(),
            'likes' => PostLike::count(),
            'comments' => PostComment::count(),
            'customers' => Customer::count()
        ];
        $recentPosts = Post::withCategoryCommentsAndLikes()
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.post_id) as likes')
            ])->latest()->limit(10)->get();
        return view('dashboard', compact('cardStats', 'recentPosts'));

    }
}
