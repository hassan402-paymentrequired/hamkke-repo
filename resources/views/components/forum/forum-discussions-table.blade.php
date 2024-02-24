@php use App\Enums\PostStatus; @endphp
<div class="table-responsive text-nowrap">
    <table class="table table-bordered">
        <caption>Created Posts</caption>
        <thead>
        <tr>
            <th>Summary</th>
            <th>Status</th>
            <th>Poster</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($forumDiscussions as $entry)
            <tr>
                <td>Topic: <a href="{{ route('admin.forum-post.preview', ['forumPost' => $entry->forum_post_id, 'discussion' => $entry->id]) }}" target="_blank">
                        {{ $entry->topic }}
                    </a>
                    <br><span>{{ $entry->getBodySummary() }}</span>
                </td>
                <td>{{ $entry->post_status() }}</td>
                @if($entry->user_id)
                    @php $poster = $entry->user; @endphp
                    <td><span class="text-decoration-underline">{{ $poster->getRoleData()->display_name }}</span> :: {{ $entry->posterName() }}</td>
                @else
                    <td class="text-capitalize">{{ $entry->posterName() }}</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            @if($entry->post_status_id === PostStatus::PUBLISHED->value)
                                <a class="dropdown-item" href="{{ route('admin.forum-discussion.archive', $entry) }}">
                                    <i class="ti ti-checkbox me-1"></i>
                                    Move to Archive
                                </a>
                            @endif

                            @if($authUser->hasRoleById(ROLE_SUPER_ADMIN))
                                <a class="dropdown-item"
                                   onclick="return HamkkeJsHelpers.deleteWithComment(
                                            '{{ route('admin.forum-discussion.delete', $entry) }}'
                                       )" href="javascript:void(0);">
                                    <i class="ti ti-trash me-1"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Discussions Found..</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($forumDiscussions instanceof \Illuminate\Pagination\LengthAwarePaginator )
        {{ $forumDiscussions->links() }}
    @endif
</div>
