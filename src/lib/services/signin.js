const suid = localStorage.getItem('user_id');
if (suid) {
    window.location.href = 'index.html';
}

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../api/auth/login_auth.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('user_id', data.user_id);
            document.getElementById("loginForm").reset();
            window.location.href = 'index.html';
        } else {
            alert(data.message);
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
});