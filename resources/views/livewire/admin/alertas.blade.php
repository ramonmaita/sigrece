<div>
    @if (session('success'))
        <div class="callout callout-success">
            <h5>
                {{ session('success') }}
            </h5>
        </div>
    @endif
    @if (session('error'))
        <div class="callout callout-danger">
            <h5>
                {{ session('error') }}
            </h5>
        </div>
    @endif

</div>
