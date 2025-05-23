<!DOCTYPE html>
<html lang="en">
<head>
    <title>adminAGBC | AGBC</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.ico') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <style>
        /* Aquí va el CSS que tenías en el archivo HTML */
        @font-face {
            font-family: Poppins-Regular;
            src: url('../fonts/poppins/Poppins-Regular.ttf'); 
        }
        @font-face {
            font-family: Poppins-Bold;
            src: url('../fonts/poppins/Poppins-Bold.ttf'); 
        }
        @font-face {
            font-family: Poppins-Medium;
            src: url('../fonts/poppins/Poppins-Medium.ttf'); 
        }
        @font-face {
            font-family: Montserrat-Bold;
            src: url('../fonts/montserrat/Montserrat-Bold.ttf'); 
        }
        * {
            margin: 0px; 
            padding: 0px; 
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            font-family: Poppins-Regular, sans-serif;
        }
        a {
            font-family: Poppins-Regular;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0px;
            transition: all 0.4s;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
        }
        a:focus {
            outline: none !important;
        }
        a:hover {
            text-decoration: none;
            color: #34447C;
        }
        h1,h2,h3,h4,h5,h6 {
            margin: 0px;
        }
        p {
            font-family: Poppins-Regular;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0px;
        }
        ul, li {
            margin: 0px;
            list-style-type: none;
        }
        input {
            outline: none;
            border: none;
        }
        textarea {
            outline: none;
            border: none;
        }
        textarea:focus, input:focus {
            border-color: transparent !important;
        }
        input:focus::-webkit-input-placeholder { color:transparent; }
        input:focus:-moz-placeholder { color:transparent; }
        input:focus::-moz-placeholder { color:transparent; }
        input:focus:-ms-input-placeholder { color:transparent; }
        textarea:focus::-webkit-input-placeholder { color:transparent; }
        textarea:focus:-moz-placeholder { color:transparent; }
        textarea:focus::-moz-placeholder { color:transparent; }
        textarea:focus:-ms-input-placeholder { color:transparent; }
        input::-webkit-input-placeholder { color: #999999; }
        input:-moz-placeholder { color: #999999; }
        input::-moz-placeholder { color: #999999; }
        input:-ms-input-placeholder { color: #999999; }
        textarea::-webkit-input-placeholder { color: #999999; }
        textarea:-moz-placeholder { color: #999999; }
        textarea::-moz-placeholder { color: #999999; }
        textarea:-ms-input-placeholder { color: #999999; }
        button {
            outline: none !important;
            border: none;
            background: transparent;
        }
        button:hover {
            cursor: pointer;
        }
        iframe {
            border: none !important;
        }
        .txt1 {
            font-family: Poppins-Regular;
            font-size: 13px;
            line-height: 1.5;
            color: #999999;
        }
        .txt2 {
            font-family: Poppins-Regular;
            font-size: 13px;
            line-height: 1.5;
            color: #666666;
        }
        .limiter {
            width: 100%;
            margin: 0 auto;
        }
        .container-login100 {
            width: 100%;  
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: #34447C;
            background: -webkit-linear-gradient(-135deg, #B99C46, #34447C);
            background: -o-linear-gradient(-135deg, #B99C46, #34447C);
            background: -moz-linear-gradient(-135deg, #B99C46, #34447C);
            background: linear-gradient(-135deg, #B99C46, #34447C);
        }
        .wrap-login100 {
            width: 960px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 177px 130px 33px 95px;
        }
        .login100-pic {
            width: 316px;
        }
        .login100-pic img {
            max-width: 100%;
        }
        .login100-form {
            width: 290px;
        }
        .login100-form-title {
            font-family: Poppins-Bold;
            font-size: 24px;
            color: #333333;
            line-height: 1.2;
            text-align: center;
            width: 100%;
            display: block;
            padding-bottom: 54px;
        }
        .wrap-input100 {
            position: relative;
            width: 100%;
            z-index: 1;
            margin-bottom: 10px;
        }
        .input100 {
            font-family: Poppins-Medium;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
            display: block;
            width: 100%;
            background: #e6e6e6;
            height: 50px;
            border-radius: 25px;
            padding: 0 30px 0 68px;
        }
        .focus-input100 {
            display: block;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            box-shadow: 0px 0px 0px 0px;
            color: #B99C46;
        }
        .input100:focus + .focus-input100 {
            -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
            animation: anim-shadow 0.5s ease-in-out forwards;
        }
        @-webkit-keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
            }
        }
        @keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
            }
        }
        .symbol-input100 {
            font-size: 15px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding-left: 35px;
            pointer-events: none;
            color: #666666;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }
        .input100:focus + .focus-input100 + .symbol-input100 {
            color: #57b846;
            padding-left: 28px;
        }
        .container-login100-form-btn {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 20px;
        }
        .login100-form-btn {
            font-family: Montserrat-Bold;
            font-size: 15px;
            line-height: 1.5;
            color: #fff;
            text-transform: uppercase;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            background: #34447C;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 25px;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }
        .login100-form-btn:hover {
            background: #333333;
        }
        @media (max-width: 992px) {
            .wrap-login100 {
                padding: 177px 90px 33px 85px;
            }
            .login100-pic {
                width: 35%;
            }
            .login100-form {
                width: 50%;
            }
        }
        @media (max-width: 768px) {
            .wrap-login100 {
                padding: 100px 80px 33px 80px;
            }
            .login100-pic {
                display: none;
            }
            .login100-form {
                width: 100%;
            }
        }
        @media (max-width: 576px) {
            .wrap-login100 {
                padding: 100px 15px 33px 15px;
            }
        }
        .validate-input {
            position: relative;
        }
        .alert-validate::before {
            content: attr(data-validate);
            position: absolute;
            max-width: 70%;
            background-color: white;
            border: 1px solid #c80000;
            border-radius: 13px;
            padding: 4px 25px 4px 10px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 8px;
            pointer-events: none;
            font-family: Poppins-Medium;
            color: #c80000;
            font-size: 13px;
            line-height: 1.4;
            text-align: left;
            visibility: hidden;
            opacity: 0;
            -webkit-transition: opacity 0.4s;
            -o-transition: opacity 0.4s;
            -moz-transition: opacity 0.4s;
            transition: opacity 0.4s;
        }
        .alert-validate::after {
            content: "\f06a";
            font-family: FontAwesome;
            display: block;
            position: absolute;
            color: #c80000;
            font-size: 15px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 13px;
        }
        .alert-validate:hover:before {
            visibility: visible;
            opacity: 1;
        }
        @media (max-width: 992px) {
            .alert-validate::before {
                visibility: visible;
                opacity: 1;
            }
        }
        .centrado {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ url('images/MONITO.png') }}" alt="IMG">
                </div>
                
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="centrado">
                        <h2>SISTEMA INTEGRAL DE GESTIÓN PARA LA OPTIMIZACIÓN DEL SERVICIO POSTAL</h2>
                        <h3>"ADMINAGBC"</h3><br>
                    </div>
                    <span class="login100-form-title">
                        Iniciar Session
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Se requiere un correo electrónico válido: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Correo Electronico">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Se requiere contraseña">
                        <input class="input100" type="password" name="password" placeholder="Contraseña">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });
    </script>
    <script>
        (function ($) {
            "use strict";
            var input = $('.validate-input .input100');
            $('.validate-form').on('submit', function(){
                var check = true;
                for(var i=0; i<input.length; i++) {
                    if(validate(input[i]) == false){
                        showValidate(input[i]);
                        check=false;
                    }
                }
                return check;
            });
            $('.validate-form .input100').each(function(){
                $(this).focus(function(){
                    hideValidate(this);
                });
            });
            function validate (input) {
                if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                    if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                        return false;
                    }
                } else {
                    if($(input).val().trim() == ''){
                        return false;
                    }
                }
            }
            function showValidate(input) {
                var thisAlert = $(input).parent();
                $(thisAlert).addClass('alert-validate');
            }
            function hideValidate(input) {
                var thisAlert = $(input).parent();
                $(thisAlert).removeClass('alert-validate');
            }
        })(jQuery);
    </script>
</body>
</html>
