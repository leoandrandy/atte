<div>
    <h1>メール認証</h1>
    <p>メールアドレスを確認してください。確認メールが送信されました。</p>

    @if (session('status') == 'verification-link-sent')
    <p>新しい確認リンクがメールに送信されました。</p>
    @endif

    <form action="{{route('verification.send')}}" method="post">
        @csrf
        <button class="form__button-submit" type="submit">再送信</button>
    </form>


</div>