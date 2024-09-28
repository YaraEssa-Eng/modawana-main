@extends('admin.layout')

@section('main')
    <style>
        .card {
            width: 500px;
            /* margin: 30px auto; */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%)
        }

        .card-header {

            padding: 10px 20px;
            color: #49935e;
        }

        .card-body {

            padding: 20px;
        }

        .btn {
            background-color: #49935e;
            color: white
        }
    </style>

    <div style="height: 100vh; margin:0;padding:0;box-sizing:border-box;position:relative">

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;font-size: 24px">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="card">
            <div class="card-header">

                <h4>تغيير كلمة المرور</h4>
            </div>
            <div class="card-body">

                <form method="POST" id="myForm" action="{{ route('update-password') }}">
                    @csrf

                    <div>
                        <label class="label-control mb-1" for="old_password">كلمة المرور الحالية:</label>
                        <input class="form-control mb-3" type="password" id="old_password" name="old_password" required>
                    </div>

                    <div>
                        <label class="label-control mb-1" for="password">كلمة المرور الجديدة:</label>
                        <input class="form-control mb-3" type="password" id="password" name="password" required>
                    </div>

                    <div>
                        <label class="label-control mb-1" for="confirm_password">تأكيد كلمة المرور الجديدة:</label>
                        <input class="form-control mb-3" type="password" id="confirm_password" name="confirm_password"
                            required>
                    </div>

                    <button class="btn " type="submit">تغيير كلمة المرور </button>
                </form>

            </div>
        </div>

    @endsection
