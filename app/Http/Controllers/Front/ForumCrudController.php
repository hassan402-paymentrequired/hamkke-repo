<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Helpers\PostParser;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForumPostCrudRequest;
use App\Models\ForumPost;
use App\Models\ForumTag;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForumCrudController extends Controller
{
    public function index(Request $request)
    {
        $forumPostsQuery = ForumPost::leftJoin('forum_discussions', function (JoinClause $joinClause) {
                $joinClause->on('forum_discussions.forum_post_id', 'forum_posts.id')
                    ->where('forum_discussions.post_status_id', PostStatus::PUBLISHED);
            })
            ->leftJoin('forum_post_tag', 'forum_post_tag.forum_post_id', 'forum_posts.id')
//            ->leftJoin('forum_post_likes', 'forum_post_likes.forum_post_id', 'forum_posts.id')
            ->where('forum_posts.post_status_id', PostStatus::PUBLISHED);
        if($request->get('tag')){
            $tag = Tag::where('slug', $request->get('tag'))->first();
            $forumPostsQuery->where('forum_post_tag.tag_id', $tag->id);
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

    public function createThread(ForumPostCrudRequest $request)
    {
        $getForumPoster = getAuthUserPrioritizeCustomer();
        $currentGuard = auth(CUSTOMER_GUARD_NAME)->check() ? CUSTOMER_GUARD_NAME : auth()->guard()->name;
        $slug = Str::slug($request->get('topic'));
        $forumPost = ForumPost::create([
            'topic' => $request->get('topic'),
            'slug' => $slug,
            'body' => $request->get('body'),
            'user_id' => ($currentGuard !== CUSTOMER_GUARD_NAME) ? $getForumPoster->id: null,
            'customer_id' => ($currentGuard === CUSTOMER_GUARD_NAME) ? $getForumPoster->id: null,
            'post_status_id' => PostStatus::PUBLISHED
        ]);
        foreach($request->get('tags') as $tagId){
            ForumTag::create([
                'forum_post_id' => $forumPost->id,
                'tag_id' => $tagId
            ]);
        }
        flashSuccessMessage('Successful');
        return back();
    }

    public function viewPost(ForumPost $forumPost)
    {
        if($forumPost->post_status_id !== PostStatus::PUBLISHED){
            flashErrorMessage('Forum post not found');
            return redirect()->route('forum.posts');
        }
        $parsedPostBody = (new PostParser($forumPost))->parsePostBody()->render();
        $discussions = $forumPost->forum_discussions()
            ->where('post_status_id', PostStatus::PUBLISHED)
            ->paginate(10);
        $postAuthor = $forumPost->getPoster();
        return view('front-end/single-forum-post', compact('forumPost', 'discussions',
            'parsedPostBody', 'postAuthor'));
    }

    public function replyThread(Request $request, ForumPost $forumPost)
    {
        if ($forumPost->post_status_id !== PostStatus::PUBLISHED) {
            flashErrorMessage('Forum post not found');
            return redirect()->route('forum.posts');
        }
        $getForumPoster = getAuthUserPrioritizeCustomer();
        $currentGuard = auth(CUSTOMER_GUARD_NAME)->check() ? CUSTOMER_GUARD_NAME : auth()->guard()->name;
        $replyBody = $request->get('reply-body');
        // TODO Cleanup the reply-body
        // TODO Notify the poster of the reply
        $forumPost->forum_discussions()->create([
            'body' => $replyBody,
            'user_id' => ($currentGuard !== CUSTOMER_GUARD_NAME) ? $getForumPoster->id: null,
            'customer_id' => ($currentGuard === CUSTOMER_GUARD_NAME) ? $getForumPoster->id: null,
            'post_status_id' => PostStatus::PUBLISHED
        ]);
        flashSuccessMessage('Successful');
        return back();
    }
}
