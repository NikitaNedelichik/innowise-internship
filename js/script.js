const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const messages = {
    messageEmail : 'Enter correct email',
    messageConfirmEmail : 'Enter correct confirm of the email',
    authMessage : '<h4>Enter correct data</h4>'
}
let btnsDelete = document.querySelectorAll('.delete-object');
if (btnsDelete) {
    btnsDelete.forEach((elem, index) => {
        elem.addEventListener('click', (e) => {
            let isDelete = confirm('Delete this user?');
            if (!isDelete) {
                e.preventDefault();
                location.reload()
            }
        })
    })
}

const submitAuth = document.getElementById('auth_button');
let form = document.forms.auth_form;
if (!!submitAuth) {
    submitAuth.addEventListener('click', () => {
        let inputEmail = form.email;
        let inputPassword = form.password;
        if (inputEmail.value === '' || inputPassword.value === '' || !isEmailValid(inputEmail.value)) {
            form.reset();
            form.insertAdjacentHTML('beforebegin', messages.authMessage);
            setTimeout(() => {
                document.querySelector('.container').removeChild(document.querySelector('h4'));
            }, 3000);
            event.preventDefault();
        }
    })
}

const createButton = document.getElementById('create_button');
let formCreate = document.forms.create_form;
if (!!createButton) {
    createButton.addEventListener('click', () => {
        let inputEmail = formCreate.email;
        let inputEmailConfirm = formCreate.email_confirm;
        if (!isEmailValid(inputEmail.value)) {
            resetForm(formCreate, inputEmail, messages.messageEmail);
        }

        if (!isEmailValid(inputEmailConfirm.value)) {
            resetForm(formCreate, inputEmailConfirm, messages.messageConfirmEmail);
        }
    })
}

function isEmailValid(value) {
    return EMAIL_REGEXP.test(value);
}

function resetForm(form, input, message) {
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