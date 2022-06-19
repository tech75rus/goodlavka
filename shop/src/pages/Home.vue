<template>
  <div class="home">
	  <div
		  class="product border"
		  v-for="product in products"
		  :key="product.id"
	  >
			<router-link :to="'/product/' + product.id">
				<img
					:src="host + '/images' + getImageURL(product.image, 3)"
					:alt="product.name"
					loading="lazy"
				>
				<h4>{{ product.name }}</h4>
				<p>{{ product.description }}</p>
				<p>{{ product.price }} руб</p>
			</router-link>
		  <button class="button" @click="addCart(product.id)">Купить</button>
	  </div>
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
	async created() {
		await axios.get(host + '/shop/products', {
			headers: {
				'shop-token': localStorage.getItem('shop-token')
			}
		}).then(res => {
			this.products = res.data;
		}).catch(() => {
			console.log('Ошибка загрузки продуктов');
		})

	},
	methods: {
		getImageURL,
		addCart(id) {
			axios.get(host + '/shop/cart/add-product/' + id, {
				headers: {
					'shop-token': localStorage.getItem('shop-token')
				}
			}).then(response => {
				console.log(response);
			}).catch(error => {
				console.log(error);
			})
		}
	}
}
</script>

<style lang="scss">
@import "src/assets/scss/button";
@import "src/assets/scss/border.scss";

.home {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
	grid-gap: 15px;
}
.product {
	a {
		color: #000;
		text-decoration: none;
	}

	img {
		width: 100%;
	}
}
</style>
