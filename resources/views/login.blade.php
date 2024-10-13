<body class="bg-gradient-primary">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <!-- Change link to img -->
                    <img src="{{ asset('img/' . $darren2->iconlogin) }}" alt="Login Icon" class="mb-4" style="max-width: 30%; height: auto;">

                  </div>
                  <form class="user" novalidate action="{{ url('aksi_login') }}" method="POST" id="loginForm" onsubmit="return validateForm();">
                    @csrf
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Username" name="username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" 
                      name="password">
                    </div>
                    <div class="form-group">
                      <!-- You can add more elements here if needed -->
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div id="recaptcha-container" class="g-recaptcha" data-sitekey="6LdFhCAqAAAAALvjUzF22OEJLDFAIsg-k7e-aBeH"></div>
                    
                    <!-- Offline CAPTCHA -->
                    <div id="offline-captcha" style="display:none;">
                      <p>Please enter the characters shown below:</p>
                      <img src="{{ url('generateCaptcha') }}" alt="CAPTCHA">
                      <input type="text" name="backup_captcha" class="form-control mt-2" placeholder="Enter CAPTCHA" required>
                    </div>
                
                    <br>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
        function validateForm() {
            var response = grecaptcha.getResponse();
            var backupCaptcha = document.querySelector('input[name="backup_captcha"]').value;
            var isOffline = !navigator.onLine;

            if (isOffline) {
                if (backupCaptcha.length === 0) {
                    alert('Please complete the offline CAPTCHA.');
                    return false;
                }
            } else {
                if (response.length === 0) {
                    alert('Please complete the online CAPTCHA.');
                    return false;
                }
            }
            return true;
        }

        // Handle Offline Mode
        window.addEventListener('load', function() {
            if (!navigator.onLine) {
                document.getElementById('recaptcha-container').style.display = 'none';
                document.getElementById('offline-captcha').style.display = 'block';
            }
        });
    </script>
</body>
