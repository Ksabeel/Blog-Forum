<template>
	<div class="mt-5">
		<div v-if="signedIn">
	        <div class="form-group">
	            <textarea name="body" 
	            		  id="body" 
	            		  rows="5" 
	            		  placeholder="Something to say?" 
	            		  class="form-control"
	            		  required 
	            		  v-model="body">
	            		  </textarea>
	        </div>
			
	        <div class="form-group">
	            <button class="btn btn-outline-primary" 
	            		@click="addReply">Post
	            		</button>
	        </div>
		</div>
		
		<div v-else>
		    <p class="text-center mt-5">Please <a href="/login">sign in</a> to participate in this discussion</p>
		</div>
	</div>	        
	        

</template>

<script>
	import 'jquery.caret';
	import 'at.js';

	export default {

		data() {
			return {
				body: ''
			}
		},

		computed: {
			signedIn() {
				return window.App.signedIn
			}
		},

		mounted() {
			$('#body').atwho({
				at: "@",
				delay: 1000,
				callbacks: {
					remoteFilter: function(query, callback) {
						$.getJSON('/api/users', {name: query}, function(usernames) {
							callback(usernames);
						})
					}
				}
			})
		},

		methods: {
			addReply() {
				axios.post(location.pathname + '/replies', { body: this.body })
					.then(({data}) => {
						this.body = '';

						flash('Your reply has been published!')

						this.$emit('created', data)
					})
					.catch(error => {
						flash(error.response.data, 'danger')
					})
			}
		}
	};
</script>