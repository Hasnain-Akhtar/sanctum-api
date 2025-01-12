<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS without Integrity and Cross-Origin -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(45deg, #6a11cb, #2575fc);
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 400px;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-weight: bold;
      font-size: 28px;
      color: #333;
    }

    .d-flex {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #loginForm {
      margin-top: 20px;
    }

    #remember-label {
      font-size: 14px;
    }

    #login {
      background-color: #007bff;
      border-color: #007bff;
      color: #ffffff;
      font-weight: bold;
      font-size: 18px;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }

    #login:hover {
      background-color: #0069d9;
    }

    .text-center p {
      font-size: 14px;
    }

    .text-center a {
      color: #007bff;
      text-decoration: none;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-lg">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Login</h3>
        <form id="loginForm">
          <div class="mb-3">
            <label for="email" class="form-label" id="email-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label" id="password-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember" id="remember-label">Remember me</label>
          </div>
          <button id="login" type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="text-center mt-3">
          <p>Don't have an account? <a href="#">Sign up</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- jQuery (required for the AJAX request) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#login').click(function (e) {
        e.preventDefault(); // Prevent default form submission

        let email = $('#email').val();
        let password = $('#password').val();
        let remember = $('#remember').is(':checked');

        // Perform an AJAX POST request
        $.ajax({
          url: '/api/login',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({
            email: email,
            password: password,
          }),
          success: function (response) {
            if (response.status === 'success') {
              console.log('Login successful:', response);
              localStorage.setItem('token', response.token);
              window.location.href = '/allposts'; // Redirect on success
            } else {
              alert(response.message); // Show error message
            }
          },
          error: function (xhr,status,error) {
            console.error('Error occurred:', error);
            alert('An error occurred: ' + error.statusText);
          }
        });
      });
    });
  </script>
</body>
</html>
