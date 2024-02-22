@php use App\Enums\PostStatus; @endphp
<div class="table-responsive text-nowrap">
    <table class="table table-bordered">
        <caption>Forum Threads</caption>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Tags</th>
            <th>Status</th>
            <th>Posted By</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($forumPosts as $forumPost)
            @php
                $forumPoster = $forumPost->getPoster();
            @endphp
            <tr>
                <td>{{ $forumPost->id }}</td>
                <td>{{ $forumPost->topic }}</td>
                <td>{!! $forumPost->tagNames() !!}</td>
                <td>{{ $forumPost->post_status() }}</td>
                @if($forumPost->user_id)
                    @php $forumPoster = $forumPost->user; @endphp
                    <td>{{ $forumPoster->getRoleData()->display_name }} :: {{ $forumPost->posterName() }}</td>
                @else
                    <td>{{ $forumPost->posterName() }}</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            @if($forumPost->post_status_id === PostStatus::PUBLISHED)
                                <a class="dropdown-item" href="{{ route('admin.forum-post.archive', $forumPost) }}">
                                    <i class="ti ti-checkbox me-1"></i>
                                    Move to Archive
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('admin.forum-post.preview', $forumPost) }}">
                                <i class="ti ti-checkbox me-1"></i>
                                Preview
                            </a>

                            @if($authUser->hasRoleById(ROLE_SUPER_ADMIN))
                                <a class="dropdown-item"
                                   onclick="deleteForumPost('{{ route('admin.forum-post.delete', $forumPost) }}')"
                                   href="javascript:void(0);">
                                    <i class="ti ti-trash me-1"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Threads Found..</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if($forumPosts instanceof \Illuminate\Pagination\LengthAwarePaginator )
        {{ $forumPosts->links() }}
    @endif
</div>
