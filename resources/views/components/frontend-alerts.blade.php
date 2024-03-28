@php
    use Illuminate\Support\Facades\Session;$successMessage = Session::get('success');
@endphp
<div class="modal fade sitewide-alert-modal" id="errorsAlertModal" tabindex="-1" aria-labelledby="errorsAlertModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h6 class="alert-title">Oops!! The following errors occurred</h6>
                <div class="alert-paragraphs" id="error-paragraphs">
                    @foreach($errors->all() as $error)
                        <p class="sitewide-alert-message text-danger">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Post Success Modal -->
<div class="modal fade sitewide-alert-modal" id="successAlertModal" tabindex="-1"
     aria-labelledby="successAlertModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/check_circle.svg') }}" alt="Check Circle Image"/>
                <div class="alert-paragraphs">
                    <p class="sitewide-alert-message" id="success-message">{{ $successMessage }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const flashMessages = {};
    @foreach(['error', 'warning', 'info'] as $status)
        flashMessages['{{ $status }}'] = "{{ Session::get($status) }}";
    @endforeach
    console.log('flashMessages:', flashMessages);
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
                    }, 5000));
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
                        $('#alert-paragraph').append(`
                            <p class="sitewide-alert-message text-{{ $status === 'error' ? 'danger' : $status }}">{{ $alertMessage }}</p>
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

