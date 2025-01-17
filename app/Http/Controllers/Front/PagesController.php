<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostType;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function home()
    {
        $postsQuery = Post::join('categories', 'categories.id', '=', 'posts.post_category_id')
            ->join('post_types', 'post_types.id', '=', 'categories.post_type_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'categories.name as post_category',
                'categories.slug as post_category_slug',
                'users.id as author_id',
                'users.name as author_name',
                'users.avatar as author_avatar',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ]);
        $latestHallyuNews = clone $postsQuery->where('post_types.id', PostType::HALLYU)
            ->orderByDesc('posts.created_at')->limit(2)->get();
        $latestForumEntries = ForumPost::leftJoin('customers', 'customers.id', 'forum_posts.customer_id')
            ->leftJoin('users', 'users.id', 'forum_posts.user_id')
            ->leftJoin('forum_discussions', function (JoinClause $joinClause) {
                $joinClause->on('forum_discussions.forum_post_id', 'forum_posts.id')
                    ->where('forum_discussions.post_status_id', PostStatus::PUBLISHED);
            })
            ->groupBy('forum_posts.id')
            ->select([
                'forum_posts.*',
                DB::raw('count(forum_discussions.id) as discussions'),
                DB::raw('IF(forum_posts.customer_id, customers.name, users.name) as poster_name'),
                DB::raw('IF(forum_posts.customer_id, customers.avatar, users.avatar) as avatar')
            ])
            ->latest()->limit(3)->get();
        $latestLearningEntries = Category::where('post_type_id', PostType::LEARNING)
            ->limit(3)->latest()->get();
        $postTypes = PostType::all();
        $hallyuPostType = $postTypes->where('id',PostType::HALLYU)->first();
        $podcastPostType = $postTypes->where('id',PostType::PODCAST)->first();
        return view('front-end.home', compact('postTypes', 'latestHallyuNews', 'latestForumEntries', 'hallyuPostType', 'podcastPostType', 'latestLearningEntries'));
    }

    public function about()
    {
        return view('front-end.about');
    }

    public function submitContactRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'content' => 'required'
        ]);
        flashInfoMessage('Contact recipients have not been setup.');
        return back()->withInput();
    }
}
