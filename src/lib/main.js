const cuid = localStorage.getItem('user_id');

const main = Vue.createApp({
    data() {
        return {
            uid: "",
            sugg: [],
            notiff: 0
        }
    },
    created() {
        this.uid = localStorage.getItem('user_id');
        this. getAllNotif();
        this.suggestions();
    },
    methods: {
        suggestions() {
            fetch(`../api/user/suggest_user.php?uid=${cuid}`)
            .then((data) => data.json())
            .then((result) => {
                this.sugg = result;
            });
        },
        getAllNotif() {
            const eventSource = new EventSource(`../api/notif/count_notif.php?uid=${cuid}`);
            eventSource.onmessage = event => {
                const data = JSON.parse(event.data);
                this.notiff = data.total_likes;
              };
        }
    }
});

main.mount('#main');