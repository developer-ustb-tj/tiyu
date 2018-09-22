@extends('nginx.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <nginx-log-table></nginx-log-table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
