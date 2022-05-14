<template>
  <div class="basket">
    <h1>Корзина</h1>
	  <div class="but">
		  <button @click="updateCart">Обновить корзину</button>
		  <button @click="clearCart">Очистить корзину</button>
	  </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";

export default {
	name: 'Basket',
	data() {
		return {
			host: host,
		}
	},
	mounted() {
		axios.get(host + '/shop/cart-show', {
			headers: {
				'shop-token': localStorage.getItem('shop-token')
			}
		}).then(response => {
			console.log(response);
		})
	},
	methods: {
		updateCart() {
			axios.get(host + '/test/update-cart', {
				headers: {
					'shop-token': localStorage.getItem('shop-token')
				}
			}).then(response => {
				console.log(response);
			}).catch(error => {
				console.log(error);
			})
		},
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
