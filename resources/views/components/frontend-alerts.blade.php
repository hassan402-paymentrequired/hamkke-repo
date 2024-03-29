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
    const flashMessages = {
        @foreach(['success', 'error', 'warning', 'info'] as $status)
            @if (Session::has($status))
                "{{ $status }}": "{{ Session::get($status) }}",
           @endif
        @endforeach
    };

    (function ($) {
        let errorMessage = flashMessages['error'] ?? '';
        @php
            $errorMessages = implode(', ', $errors->all());
        @endphp
        @if($errorMessages)
            errorMessage += '{{ $errorMessages }}';
        @endif
        console.log({errorMessage});
        if(errorMessage) {
            flashMessages['error'] = errorMessage;
        }
        // On document load, execute the following code
        $(document).ready(function () {
            Object.keys(flashMessages).forEach(function (status) {
                let msgTitle = (status === 'success') ? 'Successful': '';
                HamkkeJsHelpers.showToast('', flashMessages[status], status)
            });
        });
    })(jQuery);
</script>

