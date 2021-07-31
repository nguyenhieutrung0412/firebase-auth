@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <h5 class="text-center pt-2">OR</h5>

                <div class="mb-0 text-center">

                  <a class="btn mt-3 shadow-lg bg-white rounded"  onClick="socialSignin('google');">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                    <span class="fa fa-google"></span> Sign in with Google
                  </a>

                  <br>

                  <a class="btn my-3 bg-primary rounded text-light" onClick="socialSignin('facebook');">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Facebook_f_logo_%282019%29.svg/600px-Facebook_f_logo_%282019%29.svg.png" />
                     Sign in with Facebook
                  </a>
                </div>

                <form id="social-login-form" action="" method="POST" style="display: none;">
                  {{ csrf_field() }}
                  <input id="access-token" name="token" type="text">
                  <input id="tokenId" name="tokenId" type="text">
                  <input id="uid" name="uid" type="text">
                  <input id="displayName" name="displayName" type="text">
                  <input id="_email" name="_email" type="text">
                </form>
                <form id="social-login-form" action="" method="POST" style="display: none;">
                  {{ csrf_field() }}
                  <input id="token" name="token" type="text">
                  <input id="tokenId" name="tokenId" type="text">
                  <input id="uid" name="uid" type="text">
                  <input id="displayName" name="displayName" type="text">
                  <input id="_email" name="_email" type="text">
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--Firebase files -->
    <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js"></script>

    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-analytics.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-firestore.js"></script>
   

    <!--google provider -->
    <script>
      // Initialize Firebase
      var config = {
         // This is the variable you got from Firebase's Firebase SDK snippet. It includes values for apiKey, authDomain, projectId, etc.
         apiKey: "AIzaSyAj6Q8W24W9vU47wxsEo55rcR9WgJWGpo8",
            authDomain: "laravel-auth-1ca1b.firebaseapp.com",
            projectId: "laravel-auth-1ca1b",
            storageBucket: "laravel-auth-1ca1b.appspot.com",
            messagingSenderId: "215127696953",
            appId: "1:215127696953:web:8af592248993b369068fe8"
      };
      firebase.initializeApp(config);
      var facebookProvider = new firebase.auth.FacebookAuthProvider();
      var googleProvider = new firebase.auth.GoogleAuthProvider();
      var facebookCallbackLink = 'login/facebook/callback';
      var googleCallbackLink = 'login/google/callback';
      async function socialSignin(provider) {
         var socialProvider = null;
         if (provider == "facebook") {
            socialProvider = facebookProvider;
            //document.getElementById('social-login-form').action = facebookCallbackLink;
         } else if (provider == "google") {
            socialProvider = googleProvider;
            document.getElementById('social-login-form').action = googleCallbackLink;
         } else {
            return;
         }
      firebase.auth().signInWithPopup(socialProvider).then(function(result) {
           /** @type {firebase.auth.OAuthCredential} */
             var credential = result.credential;
          // This gives you a Google Access Token. You can use it to access the Google API.
            var token = credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            
            console.log(user);
            
            document.getElementById('uid').value = result.user.uid;
            document.getElementById('displayName').value = result.user.displayName;
            document.getElementById('_email').value = result.user.email;
            result.user.getIdToken().then(function(result) {
                
                document.getElementById('tokenId').value = result;
              
                document.getElementById('social-login-form').submit();
            });
         }).catch(function(error) {
            // do error handling
            console.log(error);
         });
      }
      </script>
@endsection
