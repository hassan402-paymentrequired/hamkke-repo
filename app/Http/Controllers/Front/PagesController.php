<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function home()
    {
        $postsQuery = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->join('post_types', 'post_types.id', '=', 'post_categories.post_type_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'users.id as author_id',
                'users.name as author_name',
                'users.avatar as author_avatar',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ]);
        $latestHallyuNews = clone $postsQuery->where('post_types.id', PostType::HALLYU)
            ->orderByDesc('posts.created_at')->limit(3)->get();
        $latestForumEntries = clone $postsQuery->where('post_types.id', PostType::FORUM)
            ->orderByDesc('posts.created_at')->limit(3)
            ->latest()->get();
        $postTypes = PostType::all();
        $hallyuPostType = PostType::find(PostType::HALLYU);
        return view('front-end.home', compact('postTypes', 'latestHallyuNews', 'latestForumEntries', 'hallyuPostType'));
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
