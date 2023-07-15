@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p>お問い合わせフォーム</p>
        <form action="/message" method="POST">
            @csrf
            <div class="flex jc-sb">
                <p class="w-25vw bw">タイトル(50文字以内)： <span id="title-preview"></span></p>
                <textarea name="title" id="title" cols="30" rows="10" placeholder="タイトル" required></textarea>
            </div>
            <div class="flex jc-sb">
                <p class="w-25vw bw">お問い合わせ内容(1000文字以内)： <span id="content-preview"></span></p>
                <textarea name="content" id="content" cols="30" rows="10" placeholder="お問い合わせ内容" required></textarea>
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
        });

        // メッセージの内容を表示する
        $('#content').keyup(function() {
            $('#content-preview').text($(this).val());
        });

    });

</script>