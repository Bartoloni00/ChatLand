const ojo = document.getElementById('ojo')
const inputPassword = document.querySelector('.input-container>div>input')

if (ojo) {
    ojo.addEventListener('click',()=>{
        if (inputPassword.type === 'password') {
            inputPassword.type = 'text'
        } else {
            inputPassword.type = 'password'
        }
    })
}

document.addEventListener("DOMContentLoaded", () => {
    const mensajeEmergente = document.getElementsByClassName('mensajeEmergente')[0]
    if (mensajeEmergente) {
        setTimeout(()=>{
            mensajeEmergente.remove()
        }, 5000)
    }
    const chat = document.getElementsByClassName('mensajes')[0];
    if (chat) {
        chat.scrollTop = chat.scrollHeight;
    }
  });
  