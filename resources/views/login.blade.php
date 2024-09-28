<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        @media (max-width: 769px) {
            .gradient-custom-2 {
                background: linear-gradient(to right, #e78123, #12343a, #d23475, #123593);
            }
        }
    </style>

</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <section class="h-100 gradient-form p-5" style="background-color: #eee;">

        <div class="login_pad d-flex justify-content-center align-items-center h-100">

            <div class="card rounded-3 text-black w-100">
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-6 ">
                        <div class="card-body p-md-5 mx-md-4">

                            <div class="text-center">
                                <img src="{{ asset('/images/logo.jpg') }}" style="width: 185px;" alt="logo">
                                <h4 class="mt-1 mb-5 pb-1">YEP </h4>
                            </div>

                            <div class="text-dark px-3 py-4 p-md-5 mx-md-4 d-sm-block d-lg-none">
                                <h4 class="mb-4">YEP </h4>
                                <p class="small mb-0">An active youth economic empowerment network targeting
                                    disadvantaged youth and women with different kind of employment support services to
                                    boost their employability and improving their access to economic opportunities.</p>
                            </div>

                            <form method="post" action="{{ route('login') }}">
                                @csrf
                                <p class="text-center">Please login to your account</p>


                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example11">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder=" email address" value="{{ old('email', '') }}" />
                                    @error('email')
                                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                                    @enderror
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" />
                                    @error('password')
                                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                                    @enderror
                                </div>


                                <div class="text-center pt-1 pb-1">
                                    <button class="btn btn-primary gradient-custom-2 mb-3 py-3 px-5" type="submit">Log
                                        in</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class=" col-lg-6 col2 align-items-center gradient-custom-2 text-center">
                        <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                            <h4 class="mb-4">YEP</h4>
                            <p class="small mb-0">An active youth economic empowerment network targeting disadvantaged
                                youth and women with different kind of employment support services to boost their
                                employability and improving their access to economic opportunities.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</body>

</html>
