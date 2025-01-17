@php use App\Enums\PostStatus; @endphp
<div class="nav-align-top nav-tabs-shadow mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        @foreach($postStatuses as $postStatus)
            @php $isActiveTab = request()->get('post_status', PostStatus::PUBLISHED->value) == $postStatus->value; @endphp
            <li class="nav-item">
                <a href="{{ request()->url() . "?post_status={$postStatus->value}" }}">
                    <button type="button" role="tab" data-bs-toggle="tab" aria-selected="true"
                            class="nav-link {{ $isActiveTab ? 'active' : ''  }}"
                            data-bs-target="#navs-justified-{{ strtolower($postStatus->name) }}"
                            aria-controls="navs-justified-{{ strtolower($postStatus->name) }}">

                        <em class="{{ PostStatus::getIcon($postStatus->value) }}{{ $isActiveTab ? ' text-primary' : '' }} text-black ti-xs me-1">
                        </em> {{ PostStatus::getName($postStatus->value) }}
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-info ms-1">
                            {{ $postStatusGroups[$postStatus->value] ?? '0' }}
                        </span>
                    </button>
                </a>
            </li>
        @endforeach
    </ul>
</div>
