function changeInfo() {
    parent.document.getElementById("my").showModal();
    parent.getInfo();
}

function getInfo() {
    const uid = localStorage.getItem('user_id');

    fetch(`../api/follow/get_follow.php?uid=${uid}`)
    .then(data => data.json())
    .then(res => {
        console.log(res[0].username);
        document.getElementById('logid').value = res[0].user_id;
        document.getElementById('logname').value = res[0].fullname;
        document.getElementById('loguname').value = res[0].username;
        document.getElementById('selectedImage').src = ".."+ res[0].profile_pic;
    });
}

const uids = localStorage.getItem('user_id');
const updateInfoForm = parent.document.getElementById('updateInfoForm');
if (updateInfoForm) {
    updateInfoForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../api/user/update_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(() => {
            parent.document.getElementById("main_content").src = "profile.html?uid=" + uids;
            parent.document.getElementById("my").close();
        })
    });
} else {
    console.log("Not Found");
}

function displayImage() {
    const input = document.getElementById('imageInput');
    const image = document.getElementById('selectedImage');
  
    if (input.files && input.files[0]) {
      const reader = new FileReader();
  
      reader.onload = function(e) {
        image.src = e.target.result;
      };
  
      reader.readAsDataURL(input.files[0]);
    }
  }