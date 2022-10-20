@extends('layouts.app')
@section('content')
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Demo</b> OAuth 2.0</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <div class="social-auth-links text-center mb-3">
                    <a href="javascript:;" class="btn btn-block btn-success" onclick="lineOAuthLogin()">
                        <i class="fab fa-line mr-2"></i> Sign in using Line
                    </a>
                    {{--  <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>  --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function lineOAuthLogin() {
        const root_uri = "https://access.line.me/oauth2/v2.1/authorize";
        const client_id = "{{ env('LINE_CLIENT_ID') }}";
        const redirect_uri = "{{ env('APP_URL') }}"+"/oauth/member/v2/line/login/callback";
        const state = "123123";
        const scope = "profile%20openid%20email";
        const uri = `${root_uri}?response_type=code&client_id=${client_id}&redirect_uri=${redirect_uri}&state=${state}&scope=${scope}`;
        window.location.href = uri;
    }
</script>
@endsection
