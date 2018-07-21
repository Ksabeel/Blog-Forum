<template>
	<div class="float-right">
		<button type="submit" :class="classes" @click="toggle">
			<i class="fa fa-heart"></i>
			<span v-text="count"></span>
		</button>
	</div>
</template>

<script>
	export default {
		props: ['reply'],

		data() {
			return {
				count: this.reply.favoritesCount,
				active: this.reply.isFavorited
			}
		},

		computed: {
			classes() {
				return ['btn btn-sm', this.active ? 'btn-danger' : 'btn-outline-danger'];
			},

			endpoint() {
				return `/replies/${this.reply.id}/favorites`;
			}
		},

		methods: {
			toggle() {
				return this.active ? this.destroy() : this.create()
			},

			create() {
				axios.post(this.endpoint)

				this.active = true;
				this.count++;
			},

			destroy() {
				axios.delete(this.endpoint)

				this.active = false;
				this.count--;
			}
		}
	};
</script>