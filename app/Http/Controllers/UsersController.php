<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{
    //
     public function __construct() {
    	return $this->middleware('guest');
    }
   
    /* 사용자 등록 폼 생성 */
    public function create() {
    	return view('users.create');
    }

    public function store(Request $request) {
      $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $confirmCode = str_random(60);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);
       // event(new \App\Events\UserCreated($user));
      
       // auth()->login($user);

        // mail 보낸다. 
        \Mail::send('emails.auth.confirm', compact('user') , function($message) use($user) {
            $message->to($user->email);
            $message->subject("My 게시판 회원가입 확인");
        });
        
        return redirect(route('sessions.create'))->with('message', '가입 확인 메일을 확인해 주세요.');
    } 

    public function confirm($code) {
        /*
        1. $code 값을 가지는 레코드를 찾는다. users 테이블에서. 
        2. 그런 레코드가 없으면 회원가입 페이지로 redirect
        3. 그 레코드의 activated 값을 1로 변경하고
        4. confirm_code를 null 변경하고
        5. DB에 저장. 
        6. 로그인 시켜주고
        7. main 페이지로 redirection
        */
        $user = User::whereConfirmCode($code)->first();
        if(!$user) {
            return redirect(route('users.create'))->with('message', '가입 확인 실패! 잘못된 정보입니다. ');
        }
        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        \Auth::login($user)->with($user->name . '님 환영합니다. 가입 확인 되었습니다. ');
        return redirect(route('bbs.index'));
    }
}
