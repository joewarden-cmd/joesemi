document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../api/auth/signup_auth.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(() => {
        let op = document.getElementById('s');
        op.showModal();
        document.getElementById("signupForm").reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
});