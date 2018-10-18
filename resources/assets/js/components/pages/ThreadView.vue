<script>
	import Replies from '../Replies.vue';
	import SubscribeButton from '../SubscribeButton.vue';

	export default {
		props: ['thread'],

		data() {
			return {
				repliesCount: this.thread.replies_count,
				locked: this.thread.locked
			}
		},

		components: { Replies, SubscribeButton },

		methods: {
			toggleLock() {
				axios[this.locked ? 'delete' : 'post'](`/lock-threads/${this.thread.slug}`)

				this.locked = ! this.locked;
			}
		}

	};
</script>