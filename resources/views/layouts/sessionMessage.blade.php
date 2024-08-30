<div>
    {{-- Display succcess/error message --}}
    @if (session('success'))
        <div class="alert alert-success" style="border-radius: 10px">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger" style="border-radius: 10px">
            {{ session('error') }}
        </div>
    @elseif (session('warning'))
        <div class="alert alert-warning" style="border-radius: 10px">
            {{ session('warning') }}
        </div>
    @elseif (session('status'))
        <div class="alert alert-info" style="border-radius: 10px">
            {{ session('status') }}
        </div>
    @endif
</div>
