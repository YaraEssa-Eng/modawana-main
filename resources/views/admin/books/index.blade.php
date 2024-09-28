@extends('admin.layout')

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
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <a class="btn btn-success" href="{{ url('admin/books/create') }}">اضافة كتاب</a>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>العنوان</th>
                        <th>الكاتب</th>
                        <th>الكمية</th>
                        <th>Actions</th>
                    </tr>
                </thead>


                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                @if ($book->image == null)
                                    No Image
                                @else
                                    <img src="{{ url('/storage/media/books/' . $book->image) }}" style="width: 150px">
                                @endif

                            </td>
                            <td>{{ $book->title }}</td>
                            <td>
                                {{ $book->name }}
                            </td>
                            <td>{{ $book->amount }}</td>
                            <td>
                                <form action="{{ route('books.destroy', [$book->id]) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <a href="{{ route('books.edit', [$book->id]) }}" class="btn btn-primary mx-2">
                                        <i class="fa-solid fa-edit mx-2"></i>
                                    </a>

                                    <button type="submit" class="btn btn-danger mx-2"><i
                                            class="fa-solid fa-trash mx-2"></i></button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>

        </div>
    </div>



    <script>
        let table = new DataTable('#myTable', {
            // config options
        });
    </script>
@endsection
