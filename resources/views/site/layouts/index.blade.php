@extends('site.layouts.layout')

@section('main')
    <div class="container">
        <div class="row">
            @foreach ($books as $book)
                <div class="col-4 right-col mb-4">
                    <div class="article border rounded-lg shadow-lg overflow-hidden">
                        <div class="image-container">
                            @if ($book->image)
                                <img src="{{ url('/storage/media/books/' . $book->image) }}" alt="{{ $book->title }}"
                                    style="width:100%; height:auto;">
                            @else
                                <img src="/path/to/default/image.jpg" alt="Default Image" class="w-full h-48 object-cover">
                                <!-- استخدم صورة افتراضية إذا لم تكن متوفرة -->
                            @endif
                        </div>
                        <div class="text p-4">
                            <a href="#" class="text-blue-600 hover:underline">
                                <h4 class="text-lg font-semibold">{{ $book->title }}</h4>
                            </a>
                            <p class="text-gray-600 text-sm">by <span class="font-medium">{{ $book->name }}</span></p>
                            <p class="date text-gray-500 text-xs">{{ $book->created_at->format('d-m-Y') }}</p>
                            <!-- التاريخ يمكنك تغييره حسب الحاجة -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
