<div class="auth-main v1" style="background-color: #fff;">
    <div class="auth-wrapper">
        <div class="auth-form">
            <div class="error-card">
                <div class="card-body">
                    <div class="error-image-block">
                        <img class="img-fluid" style="max-width: 150px;" src="{{ asset('siwakjon2.png') }}" alt="img">
                    </div>
                    <div class="text-center">
                        <h1 class="mt-2">Oops! <span class="text-danger">Error {{ $code }}</span></h1>
                        <p class="text-danger">
                            "{{ $message }}"
                        </p>
                        <p>
                            {{ env('APP_DESC') }} </br> Developer: {{ env('APP_AUTHOR') }}
                        </p>
                        @if (url()->current() !== url()->previous())
                            <a class="btn btn-primary d-inline-flex align-items-center mb-3"
                                href="{{ url()->previous() }}"><i class="ph-duotone ph-navigation-arrow me-2"></i>
                                Kembali
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
