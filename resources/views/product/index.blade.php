@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('content')

<div class="jumbotron top-img">
    <p class="text-center text-white top-img-text">{{ config('app.name', 'Laravel')}}</p>
</div>

<div class="container">
    <div class="top__title text-center">
        All Products
    </div>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-lg-4 col-md-6">
        <a href="{{ route('product.show', $product->id) }}">
            <div class="card">
                <img src="{{ asset($product->image) }}" class="card-img"/>
            </a>
                <div class="card-body">
                    <p class="card-title">{{ $product->name }}</p>
                    <p class="card-text">¥{{ number_format($product->price) }} </p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-product-id="{{ $product->id }}">
                        カートに追加する
                    </button>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <div class="container">
                <div class="product">
                    <img class="product-img"/>
                    <div class="product__content-header text-center">
                        <div class="product__name"></div>
                        <div class="product__price"></div>
                    </div>
                    <div class="product__description"></div>
                    <form method="POST" action="{{ route('line_item.create') }}">
                        @csrf
                        <input type="hidden" name="id"/>
                        <div class="product__quantity">
                            <input type="number" name="quantity" min="1" value="1" require/>
                        </div>
                        <div class="product__btn-add-cart">
                            <button type="submit" class="btn btn-outline-secondary">カートに追加する</button>
                        </div>
                    </form>
                </div>
            </div>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
// id="exampleModal" のダイアログ表示時にデータ取得し、各種項目をセットする
$('#exampleModal').on('show.bs.modal', function (ev) {
    const productApiUrl = "{{ route('api.product.get') }}"
    const id = $(ev.relatedTarget).data('productId')

    fetch(`${productApiUrl}?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
        if (data.error) {
            alert(`通信中にエラーが発生しました。 ${data.error}`)
            return
        }

        const $modal = $(ev.target)
        $modal.find('.product-img').attr('src', data.product.image)
        $modal.find('.product__name').text(data.product.name)
        $modal.find('.product__price').text(data.product.price)
        $modal.find('.product__description').html(data.product.description)
        $modal.find('[name="id"]').val(data.product.id)
    })
})
</script>

@endsection
