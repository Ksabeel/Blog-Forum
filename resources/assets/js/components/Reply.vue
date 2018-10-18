<template>
	<div :id="'reply-'+id" class="card mt-3">
	    <div class="card-header">
	    	<div class="float-left">
		        <a :href="'/profiles/'+data.owner.name"
		        	v-text="data.owner.name">
		        </a> said <span v-text="ago"></span>
	    	</div>

			<div v-if="signedIn">
	           <favorite :reply="data"></favorite>
			</div>	        
	    </div>

	    <div class="card-body" :class="isBest ? 'bg-success text-white' : 'bg-light'">
	        <div v-if="editing">
	        	<form @submit.prevent="update">
		            <div class="form-group">
		                <textarea class="form-control" v-model="body" required></textarea>
		            </div>

		            <button class="btn btn-sm btn-primary">Update</button>
		            <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
	        	</form>
	        </div>

	        <div v-else v-html="body"></div>
	    </div>

        <div class="card-footer">
        	<div v-if="authorize('updateReply', reply)" class="float-left">
	            <button class="btn btn-sm btn-outline-secondary" @click="editing = true">Edit</button>
	            <button class="btn btn-sm btn-outline-danger" @click="destroy">Delete</button>
        	</div>

            <button class="btn btn-sm btn-outline-secondary float-right" @click="markBestReply" v-if="! isBest">Best Reply?</button>
        </div>
	</div>
</template>

<script>
	import Favorite from './Favorite.vue'
	import moment from 'moment'

	export default {
		props: ['data'],

		data() {
			return {
				body: this.data.body,
				id: this.data.id,
				editing: false,
				isBest: this.data.isBest,
				reply: this.data
			}
		},

		components: { Favorite },

		computed: {
			ago() {
				return moment(this.data.created_at).fromNow();
			},
		},

		created() {
			window.events.$on('best-reply-selected', id => {
				this.isBest = (id == this.id);
			})
		},

		methods: {
			update() {
				axios.patch(`/replies/${this.id}/update`, {
					body: this.body
				})
				.catch(error => {
					flash(error.response.data, 'danger');
					this.body;
				})

				this.editing = false;
				flash('Your reply has been updated!');
			},

			destroy() {
				axios.delete(`/replies/${this.id}`);

				this.$emit('deleted', this.id);

				flash('Your reply has been deleted!');
			},

			markBestReply() {
				axios.post(`/replies/${this.id}/best`);

				window.events.$emit('best-reply-selected', this.id);
			}
		}
	};
</script>