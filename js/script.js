const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const message = '<h4>Enter correct data</h4>';
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
            form.insertAdjacentHTML('beforebegin', message);
            setTimeout(() => {
                document.querySelector('.container').removeChild(document.querySelector('h4'));
            }, 2000);
            event.preventDefault();
        }
    })
}

function isEmailValid(value) {
    return EMAIL_REGEXP.test(value);
}