import { PostFetcher } from "./modules/ContentFetcher.js";

const postFetcher = new PostFetcher();

const app = Vue.createApp({
    data() {
        return {
            contents: [],
            curuser: ""
        };
    },
    mounted() {
        this.fetchPost();
        this.curuser = localStorage.getItem('user_id');
    },
     methods: {
        fetchPost() {
            postFetcher.fetchPost()
            .then(() => {
                this.contents = postFetcher.contents;
            });
        },
        editContent(id){
            this.contents = this.contents.map(content => ({
                ...content,
                isEditing: content.post_id === id
            }));
        },
        cancelEditContent(item) {
            item.isEditing = false;
            item.editedContent = item.content;
        },

        saveEditedContent(item) {
            fetch(`../api/content/edit_content.php?postid=${item.post_id}&content=${item.editedContent}`)
                .then(() => {
                    this.fetchPost();
                });
        },
        deletePost(id) {
            fetch(`../api/content/delete_content.php?post_id=${id}`)
            .then(() => {
                this.fetchPost();
            });
        },
        likePost(pid, uid) {
            fetch(`../api/content/like_content.php?pid=${pid}&uid=${uid}`)
            .then(() => {
                this.fetchPost();
            });
        },
        unlikePost(pid, uid) {
            fetch(`../api/content/unlike_content.php?pid=${pid}&uid=${uid}`)
            .then(() => {
                this.fetchPost();
            });
        }
  }
});

app.mount("#homepage");
