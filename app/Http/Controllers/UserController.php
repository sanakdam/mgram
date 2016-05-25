<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {

	public function postSignUp(Request $request) {

		$this->validate($request, [
			'username' => 'required|unique:users|max:24',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:4',
		]);

		$username = $request['username'];
		$email = $request['email'];
		$password = bcrypt($request['password']);

		$user = User::create([
			'username' => $username,
			'email' => $email,
			'password' => $password,
		]);

		Auth::login($user);
		return redirect()->route('account');
	}

	public function postSignIn(Request $request) {
		if (($request['username'] == 'admin') && ($request['password'] == 'admin')) {
			Auth::attempt(['username' => 'admin', 'password' => 'admin']);
			return redirect()->route('admin');
		}if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
			return redirect()->route('dashboard');
		} else {
			return redirect()->back();
		}
	}

	public function getLogout() {
		Auth::logout();
		return redirect()->route('index');
	}

	public function getAccount() {
		return view('account', ['user' => Auth::user()]);
	}

	public function getUserImage($filename) {
		$file = Storage::disk('local')->get($filename);
		return new Response($file, 200);
	}

	public function postSaveAccount(Request $request) {
		$this->validate($request, [
			'full_name' => 'max:120',
			'site' => 'max:120',
			'bio' => 'max:120',
		]);

		$user = Auth::user();
		$user->update($request->toArray());

		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$filename = $user->username . '-' . $user->id . '.jpg';

			$file->move('uploads', $filename);

		}
		return redirect()->route('account');
	}
}
