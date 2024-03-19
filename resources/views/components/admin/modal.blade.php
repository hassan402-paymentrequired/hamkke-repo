<div>
    <div class="modal" tabindex="-1" role="dialog" id="{{ $modalId }}" wire:ignore.self>
        <!-- Modal content goes here -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <!-- Backdrop -->
{{--    <div class="modal-backdrop fade"></div>--}}
</div>
