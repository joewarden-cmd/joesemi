const app = Vue.createApp({
    data() {
        return {
            comments: [],
            owner: ""
        }
    },
    mounted() {
        this.fetchComment();
        this.owner = localStorage.getItem('user_id');
    },
    methods: {
        fetchComment() {
            const postId = new URLSearchParams(window.location.search).get('post');
            fetch(`../api/comment/get_comment.php?postid=${postId}`)
                .then(response => response.json())
                .then(data => {
                    this.comments = data.map(comment => ({
                        ...comment,
                        isEditing: false,
                        editedComment: comment.comment_text
                    }));

                    console.log(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },

        editComment(id){
            this.comments = this.comments.map(comment => ({
                ...comment,
                isEditing: comment.comment_id === id
            }));
        },

        cancelEdit(item) {
            item.isEditing = false;
            item.editedComment = item.comment_text;
        },

        saveEditedComment(item) {
            fetch(`../api/comment/edit_comment.php?cid=${item.comment_id}&comment=${item.editedComment}`)
                .then(() => {
                    this.fetchComment();
                });
        },

        deleteComment(id) {
            fetch(`../api/comment/delete_comment.php?cid=${id}`)
                .then(() => {
                    this.fetchComment();
                });
        }
    }
});

app.mount('#comment');