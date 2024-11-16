<div>
    <div aria-live="container polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="margin-top: 70px;">
            @if (session('success'))
                <div class="my-2" style="z-index: 11">
                    <div id="successToast" class="toast text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-square-fill fs-3 ms-2"></i>
                            <div class="toast-body fw-bolder">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="my-2" style="z-index: 11">
                        <div id="errorToast" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-square-fill fs-3 ms-2"></i>
                                <div class="toast-body fw-bolder">
                                    {{ $error }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>