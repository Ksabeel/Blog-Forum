<script>
	import Replies from '../Replies.vue';
	import SubscribeButton from '../SubscribeButton.vue';

	export default {
		props: ['threadRepliesCount'],

		data() {
			return {
				repliesCount: this.threadRepliesCount
			}
		},

		components: { Replies, SubscribeButton },

	};
</script>