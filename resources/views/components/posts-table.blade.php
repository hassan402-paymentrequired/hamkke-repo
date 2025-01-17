<div class="table-responsive text-nowrap">
    <table class="table table-bordered">
        <caption>Created Posts</caption>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Author</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td><a href="{{ route('admin.post.preview', $post) }}">{{ $post->title }}</a></td>
                <td>{{ $post->post_category }}</td>
                <td>{{ $post->post_status_id->name }}</td>
                <td>{{ $post->author->name }}</td>
                <td>
                    @canany(['admin.post.delete', 'admin.post.update'])
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">

                            @can('admin.post.update')
                            <a class="dropdown-item" href="{{ route('admin.post.update', $post) }}">
                                <i class="ti ti-pencil me-1"></i> Edit
                            </a>
                            @endcan

                            @can('admin.post.delete')
                            <a class="dropdown-item" onclick="return HamkkeJsHelpers.deleteWithComment(
                                    '{{ route('admin.post.delete', $post) }}'
                                )" href="javascript:void(0);">
                                <i class="ti ti-trash me-1"></i> Delete
                            </a>
                            @endcan
                        </div>
                    </div>
                    @else
                        ----
                    @endcanany
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Posts Found..</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator )
    {{ $posts->links() }}
    @endif
</div>
