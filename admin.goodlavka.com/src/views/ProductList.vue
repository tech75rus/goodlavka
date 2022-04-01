<template>
  <div class="products">
	  <h1>Product</h1>
	  <router-link
		  class="list"
		  v-for="item in data"
		  :to="'/product-view/' + `${item.id}`"
		  :key="item.id"
	  >
		  <div class="text">
			  <h4>{{ item.name }}</h4>
			  <p>{{ item.description }} - {{ item.id }}</p>
		  </div>
		  <div class="price">
			  <img :src="host + '/images' + getImageURL(item.image, 3)" alt="">
			  <p>{{ item.price }}</p>
		  </div>
	  </router-link>
  </div>
</template>

<script>
import axios from 'axios';
import {host} from "../service/host";
import {getImageURL} from "../service/getImageURL";

export default {
  name: 'Product',
	data() {
  	return {
  		data: [],
		  host: host
	  }
	},
	created() {
		axios.get(host + '/products', {
			headers: {
				'token': localStorage.getItem('token')
			}
		}).then(response => {
			this.$store.dispatch('actionLoader');
			this.data = response.data['hydra:member'];
		}).catch(() => {
			this.$store.dispatch('actionLoader');
			this.$router.push('/login');
		})
	},
	methods: {
		getImageURL
	}
}
</script>
<style lang="scss" scoped>
@import "src/assets/scss/color";

.products {
	display: flex;
	flex-direction: column;
	h1 {
		margin-bottom: 30px;
	}
	.list {
		background-color: $main-color;
		height: 130px;
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		margin-bottom: 12px;
		border-radius: 5px;
		-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
		-moz-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
		box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16);
		&:hover {
			-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
			-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16);
		}
		.text {
			position: relative;
			text-align: center;
			width: 100%;
			height: 86%;
			overflow: hidden;
			margin: 5px 10px 0 10px;
			h4 {
				margin-bottom: 3px;
			}
			p {
				font-size: .9rem;
			}
			&::after {
				content: '';
				position: absolute;
				bottom: 0;
				left: 0;
				width: 100%;
				height: 30px;
				background: linear-gradient(180deg, transparent, $main-color 80%);
			}
		}
		.price {
			margin: 5px 10px 5px 0;
			p {
				font-size: .9rem;
			}
		}
		img {
			width: 100px;
			height: 100px;
			object-fit: cover;
			border-radius: 5px;
		}
	}
}
@media all and (max-width: 600px) {
	.products {
		.list {
			.text {
				h4 {
					font-size: .9rem;
				}
				p {
					font-size: .8rem;
				}
			}
			.price {
				p {
					font-size: .8rem;
				}
			}
		}
	}
}
</style>
