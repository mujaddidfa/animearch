<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
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
    </script>
</head>
<body>
    <form name="registrationForm" method="POST" action="input_user.php" onsubmit="return validateForm()">
        <table>
            <tr><td>Username</td><td> : <input name='id' type='text'></td></tr>
            <tr><td>Password</td><td> : <input name='password' type='password'></td></tr>
            <tr><td>Nama Lengkap</td><td> : <input name='name' type='text'></td></tr>
            <tr><td>Email </td><td> : <input name='email' type='text'></td></tr>
            <tr><td>
                <select name='role'>
                    <option value='admin'>admin</option>
                    <option value='user'>user</option>
                </select>
            </td></tr>
            <tr><td colspan=2><input type='submit' value='SIMPAN'></td></tr> 
        </table> 
    </form>
</body>
</html>