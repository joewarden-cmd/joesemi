const uid = localStorage.getItem('user_id');

const notif = Vue.createApp({
    data() {
        return {
            not: []
        }
    },
    mounted() {
        this.readNotif();
        this.getNotif();
    },
    methods: {
        getNotif() {
            // fetch(`../api/notif/get_notif.php?uid=${uid}`)
            // .then((data) => data.json())
            // .then((res) => {
            //     this.not = res;
            // });

            const eventSource = new EventSource(`../api/notif/get_notif.php?uid=${uid}`);
            eventSource.onmessage = event => {
                const data = JSON.parse(event.data);
                this.not = data;
              };
        },
        readNotif() {
            fetch(`../api/notif/read_notif.php?uid=${uid}`)
            .then(() => {
                this.getNotif();
            })
        }
    }
});

notif.mount('#notifa');