@extends('admin.layout')

@section('cssAndJs')
    <link rel="stylesheet" href="{{ asset('filepond/filepond.min.css') }}">

    <script src="{{ asset('filepond/filepond.min.js') }}"></script>
@endsection
@section('title')
    تعديل كتاب
@endsection
@section('main')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;font-size: 28px">{{ $error }}</p>
        @endforeach
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('books.update', [$book->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card">
            <div class="card-header text-center bg-secondary text-white">
                <h5>اضافة كتاب</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان الكتاب</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $book->title }}">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">اسم الكاتب</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $book->name }}">
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label"> كمية</label>
                    <input type="number" class="form-control" name="amount" id="amount" value="{{ $book->amount }}">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label"> السعر</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{ $book->price }}">
                </div>

                <div class="row">
                    <div class="col-2">
                        <p>Current Image</p>

                        @if ($book->image == null)
                            No Image
                        @else
                            <img src="{{ url('/storage/media/books/' . $book->image) }}" style="width: 150px">
                        @endif

                        {{-- <img src="{{ url('/storage/media/blogs/' . $blog->image) }}" style="width: 150px"> --}}
                    </div>

                    <div class="col-10">
                        <div class="mb-3">
                            <label for="name" class="form-label">Update Blog Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>

                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-secondary w-50">تعديل</button>
                </div>
            </div>
        </div>
    </form>


    <script>
        const inputElement = document.querySelector('input[id="image"]');
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                url: '{{ route('upload.books') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }

        });
    </script>
@endsection
