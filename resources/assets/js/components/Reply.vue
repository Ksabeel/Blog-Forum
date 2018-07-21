<script>
	import Favorite from './Favorite.vue'

	export default {
		props: ['attributes'],

		data() {
			return {
				body: this.attributes.body,
				editing: false
			}
		},

		components: { Favorite },

		methods: {
			update() {
				axios.patch(`/replies/${this.attributes.id}/update`, {
					body: this.body
				})

				this.editing = false;
				flash('Your reply has been updated!');
			},

			destroy() {
				axios.delete(`/replies/${this.attributes.id}`)

				$(this.$el).fadeOut(300, () => {
					flash('Your reply has been deleted!')
				})
			}
		}
	};
</script>