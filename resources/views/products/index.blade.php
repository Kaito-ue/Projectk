@extends('layouts.app')

@section('content')
<script>
    function confirmDelete(event) {
        if (!confirm('本当に削除しますか？')) {
            event.preventDefault(); // デフォルトのイベントをキャンセル
        }
    }
</script>
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>

    <!-- 検索フォーム -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="検索キーワード" class="form-control mb-2" value="{{ request('search') }}" >
            </div>
            <div class="col-md-6">
                <select name="manufacturer" class="form-control mb-2">
                    <option value="">メーカー名</option>
                    <option value="1">Coca-Cola</option>
                    <option value="2">サントリー</option>
                    <option value="3">キリン</option>
                    <option value="4">Pepsi</option>
                    <!-- 他のメーカーも必要に応じて追加 -->
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">検索</button>
    </form>

    <!-- 商品情報テーブル -->
    <div class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                    <th>商品画像</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->company ? $product->company->company_name : '未設定' }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->comment }}</td>
                        <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
                            <!-- 削除ボタンのフォーム -->
<form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" onsubmit="confirmDelete(event)">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
</form>

                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
