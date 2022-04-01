<template>
  <div class="home">
	  <router-link
		  :to="'/product/' + product.id"
		  class="product"
		  v-for="product in products">
		  <img
			  :src="host + '/images' + getImageURL(product.image, 3)"
			  :alt="product.name"
			  loading="lazy"
		  >
		  <h4>{{ product.name }}</h4>
		  <p>{{ product.description }}</p>
		  <p>{{ product.price }} руб</p>
	  </router-link>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from 'axios';
import {host} from "@/service/host";
import {getImageURL} from "@/service/getImageURL";

export default {
  name: 'Home',
	data() {
		return {
			host: host,
			products: ''
		}
	},
	mounted() {
		axios.get(host + '/products', {})
			.then(res => {
				this.products = res.data['hydra:member'];
			}).catch(err => {
			console.log(err);
			})
	},
	methods: {
		getImageURL
	}
}
</script>

<style lang="scss">
@import "src/assets/scss/button";

.home {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
	grid-gap: 15px;
}
.product {
	overflow: hidden;
	border-radius: 8px;
	background-color: #fff;
	color: #000;
	text-decoration: none;
	padding: 10px;

	-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
	-moz-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
	box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
	&:hover {
		-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
		-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
	}

	img {
		width: 100%;
	}
}
</style>
