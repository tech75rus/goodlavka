<template>
  <div class="about">
    <h1>This is an about page</h1>
	  {{ this.$store.getters.getLoginIn }}
	  <button @click="clickTrue()">True</button>
	  <button @click="clickFalse()">False</button>
  </div>
</template>
<script>
import axios from "axios";
import {host} from '../service/host'
export default {
	name: 'About',
	data() {
		return {
			name: 'Dimon',
			data: [],
			error: ''
		}
	},
	created() {
		axios.get(host + '/admin/about', {
			headers: {
				'token': localStorage.getItem('token')
			}
		}).then(() => {
			this.$store.dispatch('actionLoader');
			this.$store.dispatch('actionLoginIn');
		}).catch(() => {
			this.$router.push('/login');
			this.$store.dispatch('actionLoader');
		})
	},
	methods: {
		clickTrue() {
			this.$store.dispatch('setLoginIn');
		},
		clickFalse() {
			this.$store.dispatch('delLoginIn');
		}
	}
}
</script>
<style scoped lang="scss">
button {
	color: black;
}
</style>
