<script>
	import Replies from '../Replies.vue';

	export default {
		props: ['threadRepliesCount'],

		data() {
			return {
				repliesCount: this.threadRepliesCount
			}
		},

		components: { Replies },

	};
</script>