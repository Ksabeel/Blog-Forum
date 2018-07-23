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

	    <div class="card-body">
	        <div v-if="editing">                
	            <div class="form-group">
	                <textarea class="form-control" v-model="body"></textarea>
	            </div>

	            <button class="btn btn-sm btn-primary" @click="update">Update</button>
	            <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
	        </div>

	        <div v-else v-text="body"></div>
	    </div>

        <div class="card-footer" v-if="canUpdate">
            <button class="btn btn-sm btn-outline-secondary" @click="editing = true">Edit</button>
            <button class="btn btn-sm btn-outline-danger" @click="destroy">Delete</button>
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
				editing: false
			}
		},

		components: { Favorite },

		computed: {
			ago() {
				return moment(this.data.created_at).fromNow()
			},

			signedIn() {
				return window.App.signedIn
			},

			canUpdate() {
				return this.authorize(user => this.data.user_id == user.id)
			}
		},

		methods: {
			update() {
				axios.patch(`/replies/${this.data.id}/update`, {
					body: this.body
				})

				this.editing = false;
				flash('Your reply has been updated!');
			},

			destroy() {
				axios.delete(`/replies/${this.data.id}`)

				this.$emit('deleted', this.data.id)

				flash('Your reply has been deleted!')
			}
		}
	};
</script>