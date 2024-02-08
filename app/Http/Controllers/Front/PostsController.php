<?php

namespace App\Http\Controllers\Front;

use App\Helpers\PostParser;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Models\Customer;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostType;
use App\Models\User;
use App\Notifications\CustomerWelcomeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        $latestPosts = Post::withCategoryCommentsAndLikes()
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                'users.id as author_id',
                'users.name as author_name',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ])
            ->latest()
            ->paginate(10);
        return view('front-end.home', compact('latestPosts'));
    }

    public function singlePost(Post $post)
    {
        $postAuthor = $post->author;
        $postComments = PostComment::leftJoin('customers', 'customers.id', 'post_comments.customer_id')
            ->where('post_comments.post_id', $post->id)
            ->select([
                'post_comments.*',
                'customers.name as customer_name',
                'customers.username as username'
            ])->get();
        $postCategory = $post->post_category;
        $relatedPosts = Post::withCategoryCommentsAndLikes()
            ->where('posts.id', '!=', $post->id)
            ->where(function ($q) use ($postCategory) {
                $q->where('post_categories.id', $postCategory->id)
                    ->orWhere('post_types.id', $postCategory->post_type_id);
            })
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'post_categories.name as post_category',
                'post_categories.slug as post_category_slug',
                'post_types.name as post_type',
                'post_types.slug as post_type_slug',
                'users.id as author_id',
                'users.name as author_name',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ])
            ->latest()
            ->limit(3)->get();
        $parsedPostBody = (new PostParser($post))->parsePostBody()->render();
        return view('front-end.single-post', compact('post', 'postComments', 'postAuthor', 'relatedPosts', 'parsedPostBody'));
    }

    public function postsByPostCategory(PostType $post_type, PostCategory $post_category = null)
    {
        if($post_type->id === PostType::FORUM){
            return $this->getForumPosts($post_category);
        }
        $postType = $post_type;
        $postCategories = $postType->post_categories;
        $selectedCategory = $post_category;
        $postsQuery = Post::join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author')
            ->where('post_categories.post_type_id', $postType->id);
        if($selectedCategory) {
            $postsQuery->where('posts.post_category_id', $selectedCategory->id);
        }
        $posts = $postsQuery->groupBy('posts.id')->select([
            'posts.*',
            'post_categories.name as post_category',
            'post_categories.slug as post_category_slug',
            'users.id as author_id',
            'users.name as author_name',
            'users.avatar as author_avatar',
            DB::raw('COUNT(post_comments.id) as comments'),
            DB::raw('COUNT(post_likes.customer_id) as likes')
        ])
        ->latest()
        ->paginate(10);
        return view('front-end.post-type-template', compact('posts', 'postType', 'postCategories', 'selectedCategory', 'selectedCategory'));
    }

    public function getForumPosts(PostCategory $postCategory = null)
    {

    }
    public function postComment(PostCommentRequest $request, Post $post)
    {
        if(auth(CUSTOMER_GUARD_NAME)->check()){
            $post->comments()->create([
                'customer_id' => auth()->guard('customer')->id(),
                'reply_to' => $request->reply_to,
                'body' => $request->comment
            ]);
            flashSuccessMessage('Comment sent successfully');
            return back();
        }
        /**
         * @var User $authUser
         */
        $loginAttemptPassed = false;
        if($request->get('registration_request') === 'yes'){
            $customer = Customer::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->register_password)
            ]);
            $customer->notify(new CustomerWelcomeNotification());
            $loginAttemptPassed = Auth::guard(CUSTOMER_GUARD_NAME)->attempt([
                'email' => $request->email,
                'password' => $request->register_password
            ], $request->get('remember_me') === 'on');
        } elseif ($request->get('login_request') === 'yes') {
            $loginAttemptPassed = Auth::guard(CUSTOMER_GUARD_NAME)->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $request->get('remember_me') === 'on');
        }
        if($loginAttemptPassed){
            $request->session()->regenerate();
            $post->comments()->create([
                'customer_id' => auth(CUSTOMER_GUARD_NAME)->id(),
                'reply_to' => $request->reply_to,
                'body' => $request->comment
            ]);
            flashSuccessMessage('Comment sent successfully');
        } else {
            flashErrorMessage('Invalid credentials');
        }
        return back();

    }
//    public function likePost(PostCommentRequest $request, Post $post)
//    {
//        if(auth(CUSTOMER_GUARD_NAME)->check()){
//            $post->likes()->create([
//                'customer_id' => auth(CUSTOMER_GUARD_NAME)->id(),
//            ]);
//            flashSuccessMessage('Comment sent successfully');
//            return back();
//        }
//        /**
//         * @var User $authUser
//         */
//        $loginAttemptPassed = false;
//        if($request->get('registration_request') === 'yes'){
//            $authUser = Customer::create([
//                'name' => $request->name,
//                'username' => $request->username,
//                'email' => $request->email,
//                'password' => bcrypt($request->register_password)
//            ]);
//            $authUser->notify(new CustomerWelcomeNotification());
//            $loginAttemptPassed = Auth::guard(CUSTOMER_GUARD_NAME)->attempt([
//                'email' => $request->email,
//                'password' => $request->password
//            ], $request->get('remember_me') === 'on');
//        } elseif ($request->get('login_request') === 'yes') {
//            $loginAttemptPassed = Auth::guard(CUSTOMER_GUARD_NAME)->attempt([
//                'email' => $request->email,
//                'password' => $request->password
//            ], $request->get('remember_me') === 'on');
//        }
//        if($loginAttemptPassed){
//            $request->session()->regenerate();
//            $post->comments()->create([
//                'customer_id' => auth(CUSTOMER_GUARD_NAME)->id(),
//                'reply_to' => $request->reply_to,
//                'body' => $request->comment
//            ]);
//            flashSuccessMessage('Comment sent successfully');
//        } else {
//            flashErrorMessage('Invalid credentials');
//        }
//        return back();
//
//    }
}
