window.addEventListener('load', youExist);

function youExist() {
    const userIdx = localStorage.getItem('user_id');
    if (!userIdx) {
        window.location.href = 'signin.html';
    }
}

function signoutUser() {
    localStorage.removeItem('user_id');
    location.href = 'signin.html';
}