@extends('layout')

@section('title', '| Welcome')

@section('style')
    <style>
        .Sign{
            margin-bottom: 25vh;
            text-align: center;
            width: 100vh;
        }

        .Sign span {
            font-size: 7vh;
        }

        .Sign > input {
            padding: 1vh;
            font-size: 3vh;
            width: 40vh;
            border: 1px solid black;
            background-color: rgba(0, 0, 0, 0.25);
        }

        .Sign > input[type='submit'] {
            background-color: black;
            border: 1px solid black;
            font-size: 4vh;
            width: 42.2vh;
        }

        .Sign > input:focus, .Sign > input[type='submit']:hover, .Sign > input[type='button']:hover {
            border-color: white; transition: border-color .3s ease-in-out;
        }

        .Sign > input[type='button'] {
            width: 20vh;
            font-size: 2vh;
            background-color: black;
            margin-top: 1vh;
        }

        .Sign .Error {
            color: rgb(255, 0, 0);
            font-size: 2vh;
        }

    </style>
@endsection

@section('body')
    <div class="centered">
        <form id="SignIN" action="/SignIN" method="post" class="Sign" {{ old('_signup') != null ? 'hidden' : '' }}>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <span id="Span">Welcome to Task Scheduler</span><br/>
            <input name="email" type="email" autofocus placeholder="Email" pattern="^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$" required value="{{ old('email') }}"><br/>
            <input name="password" type="password" placeholder="Password" pattern="^[a-z0-9_-]{6,18}$" required value="{{ old('password') }}"><br/>
            @if(!empty($Invalid))
                <span class="Error">{{ $Invalid }}</span><br/>
            @endif

            <input type="submit" value="Sign in"><br/>
            <input type="button" id="OnCreate" value="Create account">
        </form>

        <form id="SignUP" action="/SignUP" method="post" class="Sign" {{ old('_signup') != null ? '' : 'hidden' }} >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input id="_signup" type="hidden" name="_signup" value="{{ old('_signup') }}">
            <span>Registration</span><br/>
            <input name="email" type="email" autofocus placeholder="Your email" {{--pattern="^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$" required--}} value="{{ old('email') }}"><br/>
            @if($errors->first('email') != null)
                <span class="Error">{{ $errors->first('email') }}</span><br/>
            @endif

            <input id="password" name="password" type="password" placeholder="Create password" {{--pattern="^[a-z0-9_-]{6,18}$" required value="{{ old('password') }}"--}}><br/>
            @if($errors->first('password') != null)
                <span class="Error">{{ $errors->first('password') }}</span><br/>
            @endif

            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm a password" {{--pattern="^[a-z0-9_-]{6,18}$" required value="{{ old('password_confirmation') }}"--}}><br/>
            @if($errors->first('password_confirmation') != null)
                <span class="Error">{{ $errors->first('password_confirmation') }}</span><br/>
            @endif

            <input type="submit" value="Sign up"><br/>
            <input type="button" id="OnLogin" value="Log in">
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#OnCreate").click(function (e) {
                e.preventDefault();
                $("#_signup").attr('value', 'true');
                $('#SignIN').slideUp(500);
                $('#SignUP').slideDown(500);
                return false;
            });

            $("#OnLogin").click(function (e) {
                e.preventDefault();
                $('#Span').html('Authorization');
                $("#_signup").attr('value', null);
                $('#SignUP').slideUp(500);
                $('#SignIN').slideDown(500);
                return false;
            });
        });
    </script>
@endsection