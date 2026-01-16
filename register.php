<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup & Signin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body
    class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500"
  >
    <div
      class="bg-white shadow-lg rounded-lg p-6 transform transition-all duration-300 hover:scale-105 w-[900px]"
    >
      <div >
        <h2 class="text-xl font-bold text-center text-gray-700 mb-4">Signup</h2>
        <form class="grid grid-cols-3 gap-4" method="Post" id="signupForm">
        <input
            type="text"
            placeholder="First Name"
            id="firstName"
            name="firstName"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

          <input
            type="text"
            placeholder="Last Name"
            id="lastName"
            name="lastName"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="email"
            placeholder="Email"
            id="email"
            name="email"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="password"
            placeholder="Password"
            id="password"
            name="password"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="password"
            placeholder="Confirm Password"
            id="confirmPassword"
            name="confirmPassword"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="text"
            placeholder="Phone"
            id="phone"
            name="phone"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <select
            id="gender"
            name="gender"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <input
            type="text"
            placeholder="Passport Number"
            id="passport_no"
            name="passport_no"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="date"
            placeholder="Date of Birth"
            id="DOB"
            name="DOB"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="text"
            placeholder="Nationality"
            id="nationality"
            name="nationality"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="text"
            placeholder="Address"
            id="address"
            name="address"
            class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <button
            type="submit"
            class="col-span-3 w-full bg-blue-500 text-white p-2 rounded-md mt-4 hover:bg-blue-600 transition-all duration-300"
          >
            Signup
          </button>
        </form>
        <p class="text-center text-sm text-gray-600 mt-2">
          Already have an account?
          <a
            href="login.php"
            class="text-blue-500 font-semibold"
            >Signin</a
          >
        </p>
      </div>
    </div>

<script>
  $(document).ready(function () {

    $('#signupForm').submit(function (e) {
      e.preventDefault(); // Prevent default form submission
      let formData = $(this).serialize();

      // Send data via AJAX to the server
      $.ajax({
          type: 'POST',
          url: 'registerOperation.php?url=registration', // PHP script to handle the form data
          data: formData,
          dataType: "json",
          success: function (response) {
              // Handle success or failure
              if (response.status === 'success') {
                  Swal.fire({
                      title: 'Signup Successful!',
                      text: response.message,
                      icon: 'success',
                      confirmButtonText: "OK",
                      timer: 3000,  // Auto close after 3 seconds
                  }).then(function () {
                      // Optionally redirect to the login page after closing the alert
                      window.location.href = 'login.php';
                  });
              } else {
                  Swal.fire({
                      title: "Error!",
                      text: response.message,
                      icon: "error",
                      confirmButtonText: "Try Again",
                  });
              }
          },
          error: function () {
              Swal.fire({
                  title: "Error!",
                  text: "An error occurred while submitting the form.",
                  icon: "error",
                  confirmButtonText: "Try Again",
              });
        }
      });
    });
});
</script>


  </body>
</html>