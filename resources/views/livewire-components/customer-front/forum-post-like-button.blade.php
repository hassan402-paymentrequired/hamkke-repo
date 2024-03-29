<span>
    <span>
        {{ $forumPost->likes()->count() }}
        Likes
    </span>
    <span>
        {{ $forumPost->forum_discussions()->count() }}
        <i class="ti ti-message"></i>
        Replies
    </span>
    <hr>
    @auth(CUSTOMER_GUARD_NAME)
        @if($postLiked)
            <a href="javascript:void(0);" type="button" class="text-decoration-none" id="like-button"
                   wire:click="unlikePost" data-post-id="{{ $forumPost->slug }}">
                <i class="ti ti-thumb-up-filled"></i>
            </a>
            <span class="text">Unlike Post</span>
        @else
            <a href="javascript:void(0);" type="button" class="text-decoration-none" id="like-button"
                   wire:click="likePost" data-post-id="{{ $forumPost->slug }}">
                <i class="ti ti-thumb-up"></i>
            </a>
            <span class="text">Like Post</span>
        @endif
    @endauth
    <div wire:loading wire:target="likePost, unlikePost">
        Like Loading...
    </div>
</span>
