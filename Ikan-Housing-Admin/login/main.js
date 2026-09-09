function validateForm() {
    const username = document.forms[0]["username"].value;
    const password = document.forms[0]["password"].value;
    if (username.trim() === "" || password.trim() === "") {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}