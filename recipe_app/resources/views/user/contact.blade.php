@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p>お問い合わせフォーム</p>
        <div>  
            @if ($errors->any())  
                <ul>  
                    @foreach ($errors->all() as $error)  
                        <li>{{ $error }}</li>  
                    @endforeach  
                </ul>  
            @endif  
        </div>
        <form action="/message" method="POST">
            @csrf
            <div class="flex jc-sb">
                <p class="w-25vw bw">タイトル(50文字以内)： <span id="title-preview"></span><span id="title-number"></span></p>
                <textarea name="title" id="title" cols="30" rows="10" placeholder="タイトルはこちら" required></textarea>
            </div>
            <div class="flex jc-sb">
                <p class="w-25vw bw">お問い合わせ内容(1000文字以内)： <span id="content-preview"></span><span id="content-number"></span></p>
                <textarea name="content" id="content" cols="30" rows="10" placeholder="お問い合わせ内容はこちら" required></textarea>
            </div>
            <input type="submit" id="form-post">
        </form>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

    $(function(){
        //投稿確認
        $("#form-post").on("click", function(){
            if(window.confirm('入力内容に問題なければOKを押してください')) {
                return true;
            } else {
                return false;
            }
        });

        // タイトルの内容を表示する
        $('#title').keyup(function() {
            $('#title-preview').text($(this).val());
            $('#title-number').text(' (現在'+$(this).val().length+'文字)');
        });

        // メッセージの内容を表示する
        $('#content').keyup(function() {
            $('#content-preview').text($(this).val());
            $('#content-number').text(' (現在'+$(this).val().length+'文字)');
        });

    });

</script>