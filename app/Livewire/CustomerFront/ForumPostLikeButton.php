<?php

namespace App\Livewire\CustomerFront;

use App\Models\Customer;
use App\Models\ForumPost;
use App\Models\ForumPostLike;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ForumPostLikeButton extends Component
{
    public ForumPost $forumPost;

    public bool $postLiked = false;

    public Authenticatable|null|Customer|User $authUser;

    public ?int $modelId;
    public ?string $modelTable;

    public function mount(ForumPost $forumPost): void
    {
        $this->forumPost = $forumPost;
        $this->authUser = getAuthUserPrioritizeCustomer();
        $this->modelId = $this->authUser?->id;
        $this->modelTable = $this->authUser?->getTable();
        if($this->modelTable && $this->modelId) {
            $this->postLiked = ForumPostLike::where('forum_post_id', $this->forumPost->id)
                ->where('model_id', $this->modelId)
                ->where('model_table_name', $this->modelTable)
                ->exists();
        }
    }

    public function render(): View
    {
        return view('livewire-components.customer-front.forum-post-like-button');
    }

    public function likePost(): void
    {
        $postLike = null;
        if(!$this->postLiked){
            $postLike = ForumPostLike::create([
                'forum_post_id' => $this->forumPost->id,
                'model_id' => $this->modelId,
                'model_table_name' => $this->modelTable
            ]);
        }
        $this->postLiked = !empty($postLike);
    }

    public function unlikePost(): void
    {
        if($this->postLiked){
            ForumPostLike::where('forum_post_id', $this->forumPost->id)
                ->where('model_id', $this->modelId)
                ->where('model_table_name', $this->modelTable)
                ->delete();
        }
        $this->postLiked = false;
    }
}
