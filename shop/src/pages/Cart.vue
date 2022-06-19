<template>
  <div class="basket">
	  <h1>Корзина</h1>
	  <div class="cart-detail" v-for="detail in cart.productsCarts">
      <router-link :to="'/product/' + detail.product.id">
        <img
            class="cart-detail-image"
            :src="host + '/images' + getImageURL(detail.product.image, 3)"
            :alt="detail.product.name"
        >
        <p class="cart-detail-name">{{ detail.product.name }} </p>
      </router-link>
      <p class="cart-detail-price">{{ detail.product.price }}</p>
      <p class="cart-detail-count">{{detail.count}} шт.</p>
      <p class="cart-detail-sum">{{ detail.price }} ₽</p>
	  </div>
	  <p>Сумма корзины - {{cart.price}}</p>
	  <div class="but">
		  <button @click="clearCart">Очистить корзину</button>
      <button @click="pay" class="pay">Купить</button>
	  </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";
import {getImageURL} from "@/service/getImageURL";

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
		}).catch(error => {
			console.log(error);
		})
	},
	methods: {
    getImageURL,
		clearCart() {
			axios.get(host + '/shop/cart/clear-cart', {
				headers: {
					'shop-token': localStorage.getItem('shop-token')
				}
			}).then(response => {
				this.cart = response.data;
			}).catch(error => {
				console.log(error);
			})
		},
    pay() {
      axios.post(host + '/shop/test-pay', {}, {
        headers: {
          'shop-token': localStorage.getItem('shop-token')
        }
      }).then(response => {
        window.location.href = response.data
      }).catch(error => {
        console.log(error);
      })
    }
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
.pay:hover {
  background-color: #8be38f;
}
.cart-detail {
  display: grid;
  grid-template-areas:
    "image price count sum"
    "name price count sum";
  justify-content: space-between;
  align-items: center;
  border: 1px solid #000;
  padding: 5px;
  margin: 10px 0;
  >a {
    text-decoration: none;
    color: #000000;
  }
  .cart-detail-image {
    width: 100px;
    grid-area: image;
  }
  .cart-detail-name {
    grid-area: name;
  }
  .cart-detail-price {
    grid-area: price;
  }
  .cart-detail-count {
    grid-area: count;
  }
  .cart-detail-sum {
    grid-area: sum;
  }
}
</style>
