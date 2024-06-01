const suid = localStorage.getItem('user_id');
const uid = new URLSearchParams(window.location.search).get('uid');

const app = Vue.createApp({
    data() {
        return {
            items: [],
            mepost: [],
            following: "",
            cuser: false,
        }
    },
    mounted() {
        if(uid == suid) {
            this.cuser = true;
        }

        this.getProfileInfo();
        this.fetchMePost();
    },
    methods: {
        getProfileInfo() {
            fetch(`../api/follow/get_follow.php?uid=${uid}`)
            .then(response => response.json())
            .then(data => {
                this.items = data[0];
            });

            fetch(`../api/follow/get_follow.php?uid=${suid}`)
            .then(response => response.json())
            .then(data => {
                //console.error(data.length);
                for (let i = 0; i < data.length; i++) {
                    // console.error(data[i].following_id);
                    // console.error(uid);
                    if (data[i].following_id == uid) {
                        this.following = true;
                        // console.error(data);
                        break;
                    }
                }
            });
        },
        followToggle() {
            // const fsuid = localStorage.getItem('user_id');
            // const fuid = new URLSearchParams(window.location.search).get('uid');
        
            if (this.following) {
                fetch(`../api/follow/remove_follow.php?uid=${suid}&suid=${uid}`)
                .then(() => {
                    this.following = false;
                    this.getProfileInfo();
                });
            } else {
                fetch(`../api/follow/user_follow.php?uid=${suid}&suid=${uid}`)
                .then(() => {
                    this.following = true;
                    this.getProfileInfo();
                });
            }
        },

        fetchMePost() {

            // const muid = new URLSearchParams(window.location.search).get('uid');

            fetch(`../api/content/get_content.php?cuid=${uid}`)
            .then((response) => response.json())
            .then((data) => {
              this.mepost = data;
            })
            .catch((error) => {
              console.error("Error fetching data:", error);
            });
        }
    }
});

app.mount('#profile');
