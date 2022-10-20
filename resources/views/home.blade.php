@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hi {{ Auth::user()->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($is_subscribe)
                    <form method="post" action="{{ route('users.update', ['user_id' => Auth::user()->id ]) }}" class="container-fluid">
                        @csrf
                        @method('PUT')
                        <input name="subscribe" type="text" value="false" hidden>
                        <button type="submit" class="btn btn-block btn-danger">
                            <i class="fab fa-line mr-2"></i> 取消 LINE Notify 通知
                        </button>
                    </form>
                @else
                    <button class="btn btn-block btn-success" onclick="lineOAuthLogin()">
                        <i class="fab fa-line mr-2"></i> 訂閱 LINE Notify 通知
                    </button>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    function lineOAuthLogin() {
        const root_uri = "https://notify-bot.line.me/oauth/authorize";
        const client_id = "{{ env('LINE_NOTIFY_CLIENT_ID') }}";
        const redirect_uri = "{{ env('APP_URL') }}"+"/oauth/member/v2/line/notify/login/callback";
        const state = "{{ auth::user()->id }}";
        const scope = "notify";
        const uri = `${root_uri}?response_type=code&client_id=${client_id}&redirect_uri=${redirect_uri}&state=${state}&scope=${scope}`;
        window.location.href = uri;
    }
</script>
@endsection