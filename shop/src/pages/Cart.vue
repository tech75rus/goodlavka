<template>
  <div class="basket">
	  <h1>Корзина</h1>
	  <p v-for="product in cart.productsCart">
		  Product - {{product}}
	  </p>
	  <p>Сумма - {{cart.price}}</p>
	  <div class="but">
		  <button @click="clearCart">Очистить корзину</button>
	  </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";

export default {
	name: 'Cart',
	data() {
		return {
			host: host,
			cart: '',
		}
	},
	mounted() {
		axios.get(host + '/shop/cart-show', {
			headers: {
				'shop-token': localStorage.getItem('shop-token')
			}
		}).then(response => {
			this.cart = response.data;
			console.log(response);
		}).catch(error => {
			console.log(error);
		})
	},
	methods: {
		clearCart() {
			axios.get(host + '/shop/cart/clear-cart', {
				headers: {
					'shop-token': localStorage.getItem('shop-token')
				}
			}).then(res => {
				console.log(res);
			})
		},
	}
}
</script>

<style lang="scss" scoped>
.but {
	margin-top: 20px;
}
button {
	padding: 5px;
	margin-right: 10px;
	background-color: transparent;
	border: #2c3e50 1px solid;
	border-radius: 4px;
	&:hover {
		cursor: pointer;
		background-color: #e38ba3;
	}
}
</style>
