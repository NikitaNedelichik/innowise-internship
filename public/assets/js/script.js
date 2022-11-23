const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const messages = {
    messageEmail : 'Enter correct email',
    emptyEmail : 'Enter the email',
    emptyPassword : 'Enter the password',
    messageConfirmEmail : 'Enter correct confirm of the email'
}

const submitAuth = document.getElementById('auth_button');
let form = document.forms.auth_form;
if (!!submitAuth) {
    submitAuth.addEventListener('click', () => {
        let inputEmail = form.email;
        let inputPassword = form.password;

        if (inputEmail.value === '') {
            resetFormAuth(form, inputEmail, messages.emptyEmail);
        } else if (!isEmailValid(inputEmail.value)) {
            resetFormAuth(form, inputEmail, messages.messageEmail);
        }

        if (inputPassword.value === '') {
            resetFormAuth(form, inputPassword, messages.emptyPassword);
        }
    })
}

const createButton = document.getElementById('register_button');
let formCreate = document.forms.create_form;
if (!!createButton) {
    createButton.addEventListener('click', () => {
        let inputEmail = formCreate.email;
        let inputEmailConfirm = formCreate.email_confirm;
        if (!isEmailValid(inputEmail.value)) {
            resetFormReg(formCreate, inputEmail, messages.messageEmail);
        }

        if (!isEmailValid(inputEmailConfirm.value)) {
            resetFormReg(formCreate, inputEmailConfirm, messages.messageConfirmEmail);
        }
    })
}

function isEmailValid(value) {
    return EMAIL_REGEXP.test(value);
}

function resetFormReg(form, input, message) {
    form.email.value = '';
    form.email_confirm.value = '';
    input.classList.add('is-invalid');
    let div = document.createElement('div');
    div.classList.add('invalid-feedback');
    div.innerHTML = message;
    input.insertAdjacentElement('afterend', div);
    setTimeout(() => {
        document.querySelector('.invalid-feedback').parentNode.removeChild(document.querySelector('.invalid-feedback'));
        input.classList.remove('is-invalid');
    }, 3000);
    event.preventDefault();
}

function resetFormAuth(form, input, message) {
    form.email.value = '';
    form.password.value = '';
    input.classList.add('is-invalid');
    let div = document.createElement('div');
    div.classList.add('invalid-feedback');
    div.innerHTML = message;
    input.insertAdjacentElement('afterend', div);
    setTimeout(() => {
        document.querySelector('.invalid-feedback').parentNode.removeChild(document.querySelector('.invalid-feedback'));
        input.classList.remove('is-invalid');
    }, 3000);
    event.preventDefault();
}