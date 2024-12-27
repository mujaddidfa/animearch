<!DOCTYPE html>
<html>

<head>
    <title>AnimeArch | Registrasi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
    <script>
        function validateForm() {
            var id = document.forms["registrationForm"]["id"].value;
            var name = document.forms["registrationForm"]["name"].value;
            var email = document.forms["registrationForm"]["email"].value;
            var password = document.forms["registrationForm"]["password"].value;
            var role = document.forms["registrationForm"]["role"].value;
            var errors = [];

            if (id == "") {
                errors.push("Username harus diisi.");
            }

            if (name == "") {
                errors.push("Nama lengkap harus diisi.");
            }

            if (email == "" || !email.includes("@")) {
                errors.push("Email harus diisi.");
            }

            if (password == "") {
                errors.push("Password harus diisi.");
            }

            if (role != "admin" && role != "user") {
                errors.push("Role yang dipilih tidak valid.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true;
        }

        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var checkbox = document.getElementById("showPassword");
            if (checkbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registrasi</h3>
                    </div>
                    <div class="card-body">
                        <form name="registrationForm" method="POST" action="input_user.php" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="id">Username</label>
                                <input name="id" type="text" class="form-control" id="id">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" id="password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
                                <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input name="name" type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control" id="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Registrasi</button>
                            </div>
                        </form>
                        <div class="form-group text-center">
                            <a href="login.php">Sudah punya akun? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>