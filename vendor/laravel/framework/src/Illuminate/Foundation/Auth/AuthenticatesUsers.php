<?php

namespace Illuminate\Foundation\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function customAuthenticate($username)
    {
        $user = User::where("username", $username)
            ->where("active", 1)
            ->first();
        if ($user) {
            Auth::login($user);
            return true; // Authentication successful
        } else {
            return false; // User not found
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        if (User::where("username", $username)->count() > 0) {

            $user = User::where("username", $username)->first();
            if ($user->active == 0) {
                return response()->json(["msg" => "Inactive User ID"]);
            }
            if($user->active == 1 && $user->login_type == 1){

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'http://hrisapi.prangroup.com:8083/v1/Login/HrisLogin',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => '{
                    "UserName": "'.$username.'",
                    "Password": "'.$password.'"
                  }',
                  CURLOPT_HTTPHEADER => array(
                    'S_KEYL: RxsJ4LQdkVFTv37rYfW9b6',
                    'Content-Type: application/json'
                  ),
                  // Adding Basic Auth using CURLOPT_USERPWD
                  CURLOPT_USERPWD => "auth:12Pran@123456$" // Basic Auth username:password
                ));

                $response = curl_exec($curl);
                $data = json_decode($response, true);
                if($data['succesS_CODE'] == 2000){

                    if($this->customAuthenticate($username)) {
                        Auth::login($user);
                        return response()->json(["status" => true]);
                    } else {
                        return response()->json([
                            "msg" => "Invalid User Id & Password",
                        ]);
                    }  
                } elseif ($data['succesS_CODE'] == 4000) {
                    return response()->json(["msg" => $data['succesS_MESSAGE']]);
                }

                curl_close($curl);
                echo $response;

            } elseif($user->active == 1 && $user->login_type == 3) {

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => "http://hris.prangroup.com:8696/Login/LoginHris",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>
                        '{
                          "username": "' .$username .'",
                          "password": "' .$password .'"
                        }',
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                        "Authorization: Basic YXV0aDoxMlByYW5AMTIzNDU2JA==",
                        "Cookie: ASP.NET_SessionId=eewmvke5hzs4mge5acxfbhig",
                    ],
                ]);

                $response = curl_exec($curl);
                $result = json_decode($response);
                if($result->status == "Success"){
                    if ($this->customAuthenticate($username)) {
                        Auth::login($user);
                        return response()->json(["status" => true]);
                    } else {
                        return response()->json([
                            "msg" => "Invalid User Id & Password",
                        ]);
                    }
                } elseif ($result->status == "Failed") {
                    return response()->json(["msg" => $result->message]);
                }
                curl_close($curl);

            } elseif ($user->active == 1 && $user->login_type == 2) {

                $user = User::where("username", $username)->where("active", 1)->first();
                if (password_verify($password, $user->password)) {
                    Auth::login($user);
                    return response()->json(["status" => true]);
                } else {
                    return response()->json(["msg" => "Invalid Password"]);
                }
            }

        } else {

            return response()->json(["msg" => "Invalid User Id & Password"]);
        }

        // // If the login attempt was unsuccessful we will increment the number of attempts
        // // to login and redirect the user back to the login form. Of course, when this
        // // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => "required|string",
            "password" => "required|string",
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->has("remember")
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), "password");
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        return $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user()) ?:
            redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans("auth.failed")];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()
            ->back()
            ->withInput($request->only($this->username(), "remember"))
            ->withErrors($errors);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return "username";
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect("/");
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    // Made by me: returns 1 if user is Not active
    protected function isUserNotActive($request)
    {
        $usernameMimic = $this->username();
        $user_info = User::where(
            $this->username(),
            $request->$usernameMimic
        )->get();
        if ($user_info->first()) {
            if ($user_info->first()->active == "0") {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }
}
