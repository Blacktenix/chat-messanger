const modal = document.getElementById('modal');
const createChat = document.getElementById('createChat');
// const closeBtn = document.querySelector('.close');
    createChat.onclick = function() {
    modal.style.display = 'block';
}

// closeBtn.onclick = function() {
//     modal.style.display = 'none';
// }

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}