@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    


                    
                                
      <form action="{{ route('token.regenerate') }}" method="POST">
    @csrf
    <input type="text" name="token" value="@if(isset($token)){{ $token }}@endif"  id="token" class="form-control">
    <button type="submit" class="btn btn-primary">Regenerate Token</button>
</form>

<button id="copyBtn" class="btn btn-secondary">Copy Token</button>
<button id="revokeBtn" class="btn btn-danger">Revoke Token</button>
<button id="enableBtn" class="btn btn-success">Re-enable Token</button>

<script>
    // Copy token functionality
    document.getElementById('copyBtn').onclick = function() {
        const token = document.getElementById('token');
        token.select();
        document.execCommand('copy');
        alert('Token copied!');
    };
</script>






                </div>
            </div>
        </div>
    </div>
</div>
@endsection
