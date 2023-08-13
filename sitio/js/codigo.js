const ojo = document.getElementById('ojo');
const inputPassword = document.querySelector('.input-container>div>input');

ojo.addEventListener('click',()=>{
    if (inputPassword.type === 'password') {
        inputPassword.type = 'text';
    } else {
        inputPassword.type = 'password';
    }
})