@php
$successMessage = \Illuminate\Support\Facades\Session::get('success');
@endphp
<div class="modal fade" id="errorsAlertModal" tabindex="-1" aria-labelledby="errorsAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h6>Oops!!</h6>
                <h6>The following errors occurred</h6>
                <div id="error-paragraphs">
                    @foreach($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successAlertModal" tabindex="-1" aria-labelledby="successAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/success-icon.png') }}" alt="Success icon"/>
                <h6 id="success-message">{{ $successMessage }}</h6>
            </div>
        </div>
    </div>
</div>
<script>
    (function ($) {
        // On document load, execute the following code
        $(document).ready(function () {
            // When the successAlertModal is about to be shown
            $('#successAlertModal, #errorsAlertModal').on('show.bs.modal', function () {

                const _this = $(this);

                // Clear any existing timeout to hide the modal
                clearTimeout(_this.data('hideInterval'));

                // Set a new timeout to hide the modal after 3000 milliseconds (3 seconds)
                _this.data('hideInterval', setTimeout(function () {
                    _this.modal('hide');
                }, 3000));
            });

            // PHP code to set default values for alertStatuses and sessionKeys
            @php
                $alertStatuses = $alertStatuses ?? ['error', 'warning', 'info'];
                $sessionKeys = array_keys(session()->all());
                $statusesInSession = array_intersect($sessionKeys, $alertStatuses);
            @endphp

            // If there is a 'success' message in the session, show the successAlertModal
            @if($successMessage)
                $('#successAlertModal').modal('show');
            @elseif(!empty($statusesInSession))

                // Loop through each status in $statusesInSession
                @foreach ($statusesInSession as $status)

                // If there is a message for the current status, append a paragraph to the 'error-paragraphs' element
                @if($alertMessage = Session::get($status))
                    $('#error-paragraphs').append(`
                        <p class='text-{{ $status }}'>{{ $alertMessage }}</p>
                    `);
                @endif

                // End of loop
                @endforeach
            @endif

            @if(empty($successMessage))
                // If there are paragraphs in the 'error-paragraphs' element, show the errorsAlertModal
                if ($('#error-paragraphs p').length > 0) {
                    $('#errorsAlertModal').modal('show')
                }
            @endif
        });
    })(jQuery);
</script>

