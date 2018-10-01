<template>
	<div>
		<div class="d-inline-flex">
			<img :src="avatar" alt="" width="50" height="50" class="mr-2">

			<h1 class="mb-2" v-text="user.name">
			    <small>Since {{ ago }}</small>
			</h1>
		</div>

	    <form method="POST" v-if="canUpdate">
	        <ImageUpload name="avatar" @loaded="onLoad"></ImageUpload>
	    </form>

	</div>
</template>

<script>
	import moment from 'moment'
	import ImageUpload from './ImageUpload.vue'

	export default {
		props: ['user'],

		data() {
			return {
				avatar: this.user.avatar_path
			}
		},

		components: { ImageUpload },

		computed: {
			ago() {
				return moment(this.user.created_at).fromNow();
			},

			canUpdate() {
				return this.authorize(user => user.id === this.user.id);
			}
		},

		methods: {
			onLoad(avatar) {
				this.avatar = avatar.src;

				this.persist(avatar.file);
			},

			persist(avatar) {
				let data = new FormData();

				data.append('avatar', avatar);

				axios.post(`/api/users/${this.user.name}/avatar`, data)
					.then(() => flash('Avatar Uploaded!'))
			}
		}
	};
</script>