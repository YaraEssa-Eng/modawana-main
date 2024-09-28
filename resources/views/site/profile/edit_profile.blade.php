@extends('site.layouts.layout')
@section('main')

    <style>
        .card {
            margin-bottom: 15px;
            /* مسافة بين البطاقات */
        }

        .cover-photo {
            width: 100%;
            height: 500px;
            border-radius: 15px;
            margin-bottom: 20px;
        }


        .form-group {
            margin: 10px;
            /* مسافة داخل البطاقة */
        }

        .text-center {
            margin-top: 20px;
            /* إضافة مسافة لتحسين الشكل */
        }

        #profile-preview {
            display: flex;
            justify-content: center;
            /* تمركز أفقي */
            align-items: center;
            /* تمركز عمودي إذا لزم الأمر */
            margin-bottom: 15px;
            /* إضافة مساحة تحت الصورة */
        }

        .profile-photo {
            width: 250px;
            /* عرض ثابت */
            height: 250px;
            /* طول ثابت */
            border-radius: 50%;
            /* دائري */
            object-fit: cover;
            /* يضمن أن الصورة تغطي المساحة */
            margin-bottom: 15px;
        }

        .cover-photo {
            width: 100%;
            height: 500px;
            border-radius: 15px;
            margin-bottom: 20px;
            /* مسافة أسفل الصورة */
            object-fit: cover;
            /* يضمن أن الصورة تغطي المساحة */
        }
    </style>

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
    <div class="container">
        <h1 class="text-primary">Edit Profile</h1>
        <hr>

        <!-- نموذج رفع الصورة -->
        <form action="{{ route('update.profile', $user_profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- بطاقة صورة البروفايل -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div id="profile-preview">
                        @if ($user_profile->avatar == null)
                            <img src="https://via.placeholder.com/300x300" class="profile-photo rounded-circle"
                                alt="Profile Photo">
                        @else
                            @php
                                // تحليل قيمة avatar (JSON) لاسترداد اسم الملف
                                $avatarData = json_decode($user_profile->avatar);
                                $filename = $avatarData->filename ?? null; // التأكد من وجود البيانات
                            @endphp

                            @if ($filename)
                                <img src="{{ url('/storage/media/users/' . $user_profile->name . '/images/profile/' . $filename) }}"
                                    class="profile-photo" alt="Profile Photo">
                            @else
                                <img src="{{ asset('images/300x300.png') }}" class="profile-photo rounded-circle" 
                                    alt="Profile Photo">
                            @endif
                        @endif
                    </div>
                    <h6 class="mt-2">رفع صورة مختلفة...</h6>
                    <input type="file" class="form-control mb-3" name="image" id="image">
                </div>
            </div>
            <!-- بطاقة صورة الغلاف -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div id="cover-preview">
                        @if ($user_profile->cover_image == null)
                            <img src="https://via.placeholder.com/300x300" class="cover-photo"
                                alt="Profile Photo">
                        @else
                            @php
                                // تحليل قيمة avatar (JSON) لاسترداد اسم الملف
                                $cover_imageData = json_decode($user_profile->cover_image);
                                $filename = $cover_imageData->filename ?? null; // التأكد من وجود البيانات
                            @endphp

                            @if ($filename)
                                <img src="{{ url('/storage/media/users/' . $user_profile->name . '/images/cover/' . $filename) }}"
                                    class="cover-photo" alt="Profile Photo">
                            @else
                                <img src="https://via.placeholder.com/300x300" class="cover-photo"
                                    alt="Profile Photo">
                            @endif
                        @endif
                    </div>
                    <h6 class="mt-2">رفع صورة مختلفة...</h6>
                    <input type="file" class="form-control mb-3" name="cover_image" id="cover_image">
                </div>
            </div>

            <div class="row">
                <!-- حقول النموذج -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Full name:</label>
                                <input class="form-control" type="text" name="name" value="{{ $user_profile->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Email:</label>
                                <input class="form-control" type="text" name="email"
                                    value="{{ $user_profile->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Bio:</label>
                                <textarea class="form-control" name="bio">{{ $user_profile->bio }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Skills:</label>
                                <input class="form-control" type="text" name="skills"
                                    value="{{ $user_profile->skills }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>School name:</label>
                                <input class="form-control" type="text" name="school_name"
                                    value="{{ $user_profile->school_name }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Professional title:</label>
                                <input class="form-control" type="text" name="professional_title"
                                    value="{{ $user_profile->professional_title }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Date of birth:</label>
                                <input class="form-control" type="date" name="date_of_birth"
                                    value="{{ $user_profile->date_of_birth }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Interests:</label>
                                <input class="form-control" type="text" name="interests"
                                    value="{{ $user_profile->interests }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Location:</label>
                                <input class="form-control" type="text" name="location"
                                    value="{{ $user_profile->location }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Universe name:</label>
                                <input class="form-control" type="text" name="universe_name"
                                    value="{{ $user_profile->universe_name }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Phone Number:</label>
                                <input class="form-control" type="number" name="phone_number"
                                    value="{{ $user_profile->phone_number }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </form>
    </div>

    <script>
        const userId = {{ $user_profile->id }};
        // إعدادات لرفع صورة الملف الشخصي  
        const inputElement = document.querySelector('input[id="image"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: '{{ route('upload.profile', ['id' => ':id']) }}'.replace(':id', userId),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        pond.on('addfile', (error, file) => {
            if (error) {
                console.error('Error adding file:', error);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const coverPreviewImg = document.querySelector('#profile-preview img');

                // تحديث مصدر الصورة  
                coverPreviewImg.src = e.target.result; // تعيين مصدر الصورة  
                coverPreviewImg.style.display = "block"; // إظهار صورة المعاينة بعد رفعها  
            };
            reader.readAsDataURL(file.file); // قراءة الملف كـ Data URL  
        });

        // إعدادات لرفع صورة الغلاف  
        const inputElement1 = document.querySelector('input[id="cover_image"]');
        const pond1 = FilePond.create(inputElement1);
        pond1.setOptions({
            server: {
                url: '{{ route('upload.cover', ['id' => ':id']) }}'.replace(':id', userId),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        pond1.on('addfile', (error, file) => {
            if (error) {
                console.error('Error adding file:', error);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const coverPreviewImg = document.querySelector('#cover-preview img');

                // تحديث مصدر الصورة  
                coverPreviewImg.src = e.target.result; // تعيين مصدر الصورة  
                coverPreviewImg.style.display = "block"; // إظهار صورة المعاينة بعد رفعها  

                // تعيين الخصائص المطلوبة مباشرة  
                // التأكد من أن الصورة تتناسب مع مظهر الصورة الافتراضية   
                coverPreviewImg.style.width = "100%"; // عرض 100%  
                coverPreviewImg.style.height = "500px"; // ارتفاع تلقائي  
                coverPreviewImg.style.borderRadius = "15px"; // زوايا دائرية  
                coverPreviewImg.style.objectFit = "cover"; // تأكد من تغطية المساحة   
            };
            reader.readAsDataURL(file.file); // قراءة الملف كـ Data URL  
        });
    </script>
@endsection