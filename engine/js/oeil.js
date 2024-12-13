document.addEventListener("DOMContentLoaded", function() {
    const pwdInput = document.getElementById("pwd");
    const togglePwdCheckbox = document.getElementById("togglePwd");
    
    // Basculer le type du champ mot de passe selon l'état de la checkbox
    togglePwdCheckbox.addEventListener("change", function() {
        const type = this.checked ? "text" : "password";
        pwdInput.setAttribute("type", type);
    });
});