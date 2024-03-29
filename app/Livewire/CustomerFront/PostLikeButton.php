<?php

namespace App\Livewire\CustomerFront;

use App\Models\Customer;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostLikeButton extends Component
{
    public Post $post;

    public bool $postLiked;

    public Authenticatable|null|Customer $customerAuthUser;

    public int|null $authCustomerId;

    public function mount(Post $post): void
    {
        $this->post = $post;
        $this->authCustomerId = auth(CUSTOMER_GUARD_NAME)->id();
        $this->postLiked = PostLike::where('post_id', $this->post->id)
            ->where('customer_id', $this->authCustomerId)
            ->exists();
    }

    public function render(): View
    {
        return view('livewire-components.customer-front.post-like-button');
    }

    public function likePost(): void
    {
        $postLike = null;
        if(!$this->postLiked){
            $postLike = PostLike::create([
                'post_id' => $this->post->id,
                'customer_id' => $this->authCustomerId
            ]);
        }
        $this->postLiked = !empty($postLike);
    }

    public function unlikePost(): void
    {
        if($this->postLiked){
            PostLike::where('post_id', $this->post->id)
                ->where('customer_id', $this->authCustomerId)
                ->delete();
        }
        $this->postLiked = false;
    }
}
