<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForumPostCrudRequest;
use App\Models\ForumDiscussion;
use App\Models\ForumPost;
use App\Models\ForumTag;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForumCrudController extends Controller
{
    public function index(Request $request)
    {
        $forumPostsQuery = ForumPost::leftJoin('forum_discussions', function (JoinClause $joinClause) {
                $joinClause->on('forum_discussions.forum_post_id', 'forum_posts.id')
                    ->where('forum_discussions.post_status_id', PostStatus::PUBLISHED);
            })
            ->leftJoin('forum_tags', 'forum_tags.forum_post_id', 'forum_posts.id')
//            ->leftJoin('forum_post_likes', 'forum_post_likes.forum_post_id', 'forum_posts.id')
//            ->where('forum_posts.post_status_id', PostStatus::PUBLISHED)
            ;
        if($request->get('tag')){
            $tag = Tag::where('slug', $request->get('tag'))->first();
            $forumPostsQuery->where('forum_tags.tag_id', $tag->id);
        }
        $forumPosts = $forumPostsQuery->groupBy('forum_posts.id')
            ->select([
                'forum_posts.*',
                DB::raw('count(forum_discussions.id) as discussions')
//                DB::raw('count(forum_post_likes.*)')
            ])
            ->latest()->paginate(10);
        $tags = Tag::all();
        return view('front-end/forum-posts', compact('forumPosts', 'tags'));
    }

    public function create(ForumPostCrudRequest $request)
    {
        $currentGuard = auth()->guard();
        $poster = auth($currentGuard->name)->user();
        $slug = Str::slug($request->get('post_title'));
        $forumPost = ForumPost::create([
            'topic' => $request->get('topic'),
            'slug' => $slug,
            'body' => $request->get('body'),
            'user_id' => ($currentGuard !== CUSTOMER_GUARD_NAME) ? $poster->id: null,
            'customer_id' => ($currentGuard === CUSTOMER_GUARD_NAME) ? $poster->id: null,
            'post_status_id' => PostStatus::AWAITING_APPROVAL
        ]);
        foreach($request->get('tags') as $tagId){
            ForumTag::create([
                'forum_post_id' => $forumPost->id,
                'tag_id' => $tagId
            ]);
        }
        flashSuccessMessage('Successful: Your discussion has been sent for admin approval');
        return back();
    }

    public function viewPost(ForumPost $forumPost)
    {
        if($forumPost->post_status_id !== PostStatus::PUBLISHED){
            throw new NotFoundHttpException('Forum post not found');
        }
        $discussions = $forumPost->forum_discussions()
            ->where('post_status_id', PostStatus::PUBLISHED)
            ->latest()->paginate(10);
        dd('Here');
        return view('', compact('forumPost', 'discussions'));
    }
}
