export class PostFetcher {
    
    contents = [];

    async fetchPost() {
        try {
            const cuid = localStorage.getItem('user_id');
            const response = await fetch(`../api/content/get_content.php?fuid=${cuid}&cuid=${cuid}`);
            const data = await response.json();

            this.contents = data.map(content => ({
                ...content,
                isEditing: false,
                editedContent: content.content
            }));

            return this.contents;
        } catch (error) {
            console.error("Error fetching data:", error);
            throw error;
        }
    }
}