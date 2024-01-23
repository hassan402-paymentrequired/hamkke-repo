<div class="col-md-4">
    <div class="card-box">
        <div class="overlay">
            <p><a href="{{ route('post.view', $post) }}"> {{ $post->title }}</a></p>
        </div>
        <img src="{{ getCorrectAbsolutePath($post->featured_image) }}"
             alt="Featured Image - {{ $post->title }}"/>
    </div>
</div>
