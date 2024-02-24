<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\ForumCrudController;
use App\Models\ForumDiscussion;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumDiscussionsController extends Controller
{
    public function index(Request $request)
    {
        $postStatuses = array_filter(PostStatus::cases(), function(PostStatus $postStatus){
            return $postStatus->value <> PostStatus::DRAFT->value;
        });
        $postStatusGroups = ForumDiscussion::groupBy('post_status_id')
            ->select([
                'post_status_id',
                DB::raw("COUNT(post_status_id) as posts_count")
            ])->pluck('posts_count', 'post_status_id')->toArray();

        $forumDiscussions = ForumDiscussion::join('forum_posts', function (JoinClause $joinClause) {
                $joinClause->on('forum_posts.id', 'forum_discussions.forum_post_id')
                    ->where('forum_posts.post_status_id', PostStatus::PUBLISHED->value);
            })
            ->where('forum_discussions.post_status_id', $request->get('post_status', PostStatus::PUBLISHED->value))
//            - >groupBy('forum_discussions.id')
            ->orderByDesc('forum_discussions.created_at')
            ->select([
                'forum_discussions.*',
                'forum_posts.topic',
                'forum_posts.user_id as forum_post_user_id',
                'forum_posts.customer_id as forum_post_customer_id'
            ])
            ->paginate(20);

        return view('forum-discussions.list', compact('postStatuses', 'postStatusGroups', 'forumDiscussions'));
    }

    public function delete(Request $request, ForumDiscussion $discussion)
    {
        if(!$this->getAuthUser()->hasRoleById(ROLE_SUPER_ADMIN)){
            flashErrorMessage('Inadequate permissions please contact the super admin');
            return back();
        }
        $deletionReason = $request->get('deletion_reason');
        if($deletionReason) {
            $discussion->update(['deletion_reason' => $deletionReason]);
        }
        $discussion->delete();
        flashSuccessMessage('Discussion entry deleted successfully');
        return back();
    }

    public function archive(ForumDiscussion $discussion)
    {
//        if(!$this->getAuthUser()->hasRoleById(ROLE_SUPER_ADMIN)){
//            flashErrorMessage('Inadequate permissions please contact the super admin');
//            return back();
//        }
        $discussion->update(['post_status_id' => PostStatus::ARCHIVED]);
        flashSuccessMessage('Discussion entry moved to archive successfully');
        return back();
    }
}
