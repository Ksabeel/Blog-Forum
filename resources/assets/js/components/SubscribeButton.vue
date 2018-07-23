<template>
	<div>
		<button :class="classes" @click="subscribe">Subscribe</button>
	</div>
</template>

<script>
	export default {
		props: ['threadSubscribe'],

		data() {
			return {
				active: this.threadSubscribe
			}
		},
 
		computed: {
			classes() {
				return ['btn', this.active ? 'btn-primary' : 'btn-outline-primary'];
			}
		},

		methods: {
			subscribe() {
				axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');

				this.active = ! this.active;
			}
		}
	};
</script>