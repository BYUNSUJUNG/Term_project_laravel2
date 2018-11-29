@extends('layouts.template')

@section('content')
	<form action="{{route('sessions.store')}}" method="POST">
		@csrf
		
		 <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">e-mail address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
		<div class="form-group">
			<div class="checkbox">
				<lavel>
					<input type="checkbox" name="remember" "{{old('remember')?'checked':''}}">
					로그인 기억하기 <span class="text-danger">(공용 컴퓨터에서는 사용하지 마세요!)</span>
				</lavel>
			</div>
		</div>
	 	<div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                                    Login		
                </button>
            </div>
        </div>        
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <a href="{{route('google.login')}}">
                    소셜 로그인
                </a>
            </div>
        </div>                         

		<div>
			<p class="text-center">회원이 아니라면?
				<a href="{{route('users.create')}}">
					가입하세요.
				</a>
			</p>
			<p class="text-center">
				<a href="{{route('remind.create')}}">
					비밀번호를 잊으셨나요?
				</a>
			</p>
		</div>
	</form>
@endsection