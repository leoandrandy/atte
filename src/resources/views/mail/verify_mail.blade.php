
    <div>
        <h1>メール認証</h1>
        <p>メールアドレスを確認してください。確認メールが送信されました。</p>

        @if (session('status') == 'verification-link-sent')
        <p>新しい確認リンクがメールに送信されました。</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">再送信</button>
        </form>
    </div>

@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent