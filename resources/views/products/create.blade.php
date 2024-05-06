@extends('layouts.app')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img_path").change(function() {
        previewImage(this);
    });
</script>

@section('content')
<div class="container">
    <h1 class="mb-4">商品新規登録</h1>

    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">商品一覧に戻る</a>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">

        @csrf 



        <div class="mb-3">
            <label for="product_name" class="form-label">商品名:</label>
            <input id="product_name" type="text" name="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー</label>
            <select class="form-select" id="company_id" name="company_id">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格:</label>
            <input id="price" type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数:</label>
            <input id="stock" type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">コメント:</label>
            <textarea id="comment" name="comment" class="form-control" rows="3" maxlength="100" required></textarea>
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">商品画像:</label>
            <input id="img_path" type="file" name="img_path" class="form-control"  onchange="previewImage(this);"required>
        </div>
        <img id="preview" src="#" alt="商品画像プレビュー" style="max-width: 200px; max-height: 200px;">
        <button type="submit" class="btn btn-primary">登録</button>
    </form>


</div>
@endsection

@if ($errors->has('price'))
    <span class="text-danger">{{ $errors->first('price') }}</span>
@endif

@if ($errors->has('stock'))
    <span class="text-danger">{{ $errors->first('stock') }}</span>
@endif

@if ($errors->has('comment'))
    <span class="text-danger">{{ $errors->first('comment') }}</span>
@endif


