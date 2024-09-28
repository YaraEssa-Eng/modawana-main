<!doctype html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regester</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>


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



.animated-radio[type="radio"] {
    position: relative;
    cursor: pointer;
}

.animated-radio[type="radio"]:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #fff;
    border: 1px solid #ddd;
    transition: transform 0.3s ease;
}

.animated-radio[type="radio"]:checked:before {
    transform: scale(1.2);
    border-color: #337ab7;
    background-color: #337ab7;
}

.color-change {
        transition: color 0.3s ease;
    }

    .color-change:hover {
        color: #337ab7;
    }

    .form-check-label {
        font-weight: bold;
        color: #337ab7;
    }

    .form-check-label:hover {
        color: #23527c;
    }
    </style>

</head>
<body>
<section class="h-100 gradient-form p-5" style="background-color: #eee;">

        <div class="login_pad d-flex justify-content-center align-items-center h-100">

                <div class="card rounded-3 text-black w-100">
                    <div class="row ">
                        <div class="col-sm-12 col-md-12 col-lg-6 ">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                                         style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">We are The Laravel Team</h4>
                                </div>

                                <div class="text-dark px-3 py-4 p-md-5 mx-md-4 d-sm-block d-lg-none">
                                    <h4 class="mb-4">We are more than just a company</h4>
                                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>

                                <form method="post" action="{{ url('/register') }}">
                                    @csrf
                                    <p>User</p>
                                    <p>Create new account</p>


                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Username</label>
                                        <input type="username" id="username" name="username" class="form-control"
                                               placeholder="username" value="{{ old('username', '') }}" />
                                        @error('email')
                                            <div class="error text-danger">{{ $errors->first('username') }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                               placeholder=" email address" value="{{ old('email', '') }}" />
                                        @error('email')
                                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-outline mb-4">
                                        <div class="card border-radius-10 shadow-sm hover-shadow">
                                            <div class="card-body bg-light-gray">
                                                <label class="form-label" for="gender">Gender</label> 
                                                <div class="d-flex justify-content-between">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input animated-radio" type="radio" name="gender" id="male" value="male">
                                                        <label class="form-check-label color-change" for="male"><i class="fas fa-male"></i> Male</label>
                                                    </div>
                                                    
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input animated-radio" type="radio" name="gender" id="female" value="female">
                                                        <label class="form-check-label color-change" for="female"><i class="fas fa-female"></i> Female</label>
                                                    </div>
                                                </div>
                                                @if($errors->has('gender'))
                                                    <div class="error text-danger">{{ $errors->first('gender') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" />
                                        @error('password')
                                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                                        @enderror
                                    </div>

                                

                                    <div class="text-center pt-1 pb-1">
                                        <button class="btn btn-primary gradient-custom-2 mb-3 py-3 px-5" type="submit">Register</button>
                                    </div>



                                </form>

                            </div>
                        </div>
                        <div class=" col-lg-6 col2 align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

</section>
</body>
</html>
