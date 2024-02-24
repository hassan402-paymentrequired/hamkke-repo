<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\ForumCrudController;
use App\Models\ForumPost;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumPostsController extends Controller
{
    public function index(Request $request)
    {
        $postStatuses = PostStatus::cases();
        $postStatusGroups = ForumPost::groupBy('post_status_id')
            ->select([
                'post_status_id',
                DB::raw("COUNT(post_status_id) as posts_count")
            ])->pluck('posts_count', 'post_status_id')->toArray();

        $forumPosts = ForumPost::leftJoin('forum_discussions', function (JoinClause $joinClause) {
                $joinClause->on('forum_discussions.forum_post_id', 'forum_posts.id');
            })
            ->leftJoin('forum_post_tag', 'forum_post_tag.forum_post_id', 'forum_posts.id')
            ->where('forum_posts.post_status_id', $request->get('post_status', PostStatus::PUBLISHED->value))
            ->groupBy('forum_posts.id')
            ->select([
                'forum_posts.*',
                DB::raw('count(forum_discussions.id) as discussions')
            ])->latest()->paginate(20);

        return view('forum_posts.list', compact('postStatusGroups', 'postStatuses', 'forumPosts'));

    }

    public function preview(ForumPost $forumPost)
    {
        return (new ForumCrudController())->viewPost($forumPost);
    }

    public function archive(ForumPost $forumPost)
    {
        if(!$this->getAuthUser()->hasRoleById(ROLE_SUPER_ADMIN)){
            flashErrorMessage('Inadequate permissions please contact the super admin');
            return back();
        }
        $forumPost->update(['post_status_id' => PostStatus::ARCHIVED]);
        flashSuccessMessage('Thread deleted successfully');
        return  back();
    }

    public function delete(ForumPost $forumPost)
    {
        if(!$this->getAuthUser()->hasRoleById(ROLE_SUPER_ADMIN)){
            flashErrorMessage('Inadequate permissions please contact the super admin');
            return back();
        }
        $forumPost->delete();
        flashSuccessMessage('Thread deleted successfully');
        return  back();
    }
}
