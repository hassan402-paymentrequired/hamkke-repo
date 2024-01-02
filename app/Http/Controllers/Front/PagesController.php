<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $postsQuery = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->join('post_types', 'post_types.id', '=', 'post_categories.post_type_id');
        $latestHallyuNews = clone $postsQuery->where('post_types.id', PostType::HALLYU)
            ->orderByDesc('posts.created_at')->limit(3)->get();
        $latestForumEntries = clone $postsQuery->where('post_types.id', PostType::FORUM)
            ->orderByDesc('posts.created_at')->limit(3)->get();
        $postTypes = PostType::all();
        return view('front-end.home', compact('postTypes', 'latestHallyuNews', 'latestForumEntries'));
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
