@extends('site.layouts.layout')
@section('main')

    @if ($errors->any())
        <ol>
            @foreach ($errors->all() as $error)
                <li style="color: red;font-size: 28px">{{ $error }}</li>
            @endforeach
        </ol>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container" style="padding-bottom: 40px;">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{ url('/storage/media/products/' . $product[0]->image) }}" class="img-fluid mx-auto d-block"
                    alt="products Image" style="width: 100%; height: auto;">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>{{ $product[0]->title }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-3">
                            <h5 class="card-title">Content:</h5>
                            {!! $product[0]->content !!}
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-success">
              @if (Auth::user())
              <a class="btn btn-success" href="{{ route('add_product',$product[0]->id) }}">add product</a>
              @else
              <a class="btn btn-success" href="{{ url('/user/login') }}">add product</a>     
              @endif
            </button>
        </div>
    </div>
@endsection
