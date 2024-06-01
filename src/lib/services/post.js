function clearMind() {
    document.getElementById("postForm").reset();
}

document.getElementById('postForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const userId = localStorage.getItem('user_id');
    const formData = new FormData(this);
    formData.append('userid', userId);
    fetch('../api/content/post_content.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(() => {
        clearMind();
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
});