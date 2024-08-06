export function handleResponse(successIcon, status, message, modal, modalMessage){
    let icon;
    if (status == 200) {
        icon = document.querySelector(`#${successIcon}`);
    } else {
        if (status == 404) {
            icon = document.querySelector("#not-found");
        } else {
            icon = document.querySelector("#failure");
        }
    }
    icon.classList.remove("d-none");
    modalMessage.textContent = message;
    modal.show();
}

export function resetModal(modalMessage, svgList) {
    modalMessage.textContent = "";
    svgList.forEach(element => {
        element.classList.add("d-none");
    });
}

export function validateEmail(email) {
    if (email.checkValidity() == true){
        if (!validator.isEmail(email.value)) {
            email.setCustomValidity('Invalid email address. Please check for typos.');
        }
    }
}