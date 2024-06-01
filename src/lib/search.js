const search = Vue.createApp({
    data() {
        return {
            results: [],
            searchText: ''
        }
    },
    mounted() {
        this.fetchUserX();
    },
    methods: {
        fetchUserX() {
            fetch("../api/user/search_user.php")
            .then((response) => response.json())
            .then((data) => {
                this.results = data;
            })
            .catch((error) => {
                console.error('Error fetching data:', error);
            });
        },
        performSearch() {
            this.resultsFiltered = this.results.filter(item =>
                item.fullname.toLowerCase().includes(this.searchText.toLowerCase())
            );
        },
        updateURL() {
            const params = new URLSearchParams(window.location.search);
            params.set('search', this.searchText);
            window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
        }
    },
    computed: {
        resultsFiltered() {
            return this.results.filter(item =>
                item.fullname.toLowerCase().includes(this.searchText.toLowerCase())
            );
        }
    }
});

search.mount('#search');
