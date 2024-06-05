function validateForm() {
    var password = document.forms["registrationForm"]["password"].value;
    var error = "";
    if (password.length < 8) {
        error = "La password deve avere almeno 8 caratteri.";
    } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        error = "La password deve contenere almeno un segno speciale.";
    } else if (!/[0-9]/.test(password)) {
        error = "La password deve contenere almeno un numero.";
    }
    if (error) {
        alert(error);
        return false;
    }
    return true;
}
