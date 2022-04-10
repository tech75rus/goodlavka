<template>
	<div class="product-view">
		<h3 class="title">{{ data.name }}</h3>
		<p class="description">{{ data.description }}</p>
		<div class="price">{{ data.price }}</div>
		<img class="image" :src="host + '/images' + getImageURL(data.image, 1)" alt="">
		<button @click="updateProduct()">Update product</button>
		<button @click="deleteProduct(data.id)">Delete product</button>
		<div v-if="message" class="message error">
			Hello
		</div>
	</div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";
import {getImageURL} from "@/service/getImageURL";

export default {
	name: "ProductView",
	data() {
		return {
			data: [],
			host: host,
			message: ''
		}
	},
	created() {
		axios.get(host + '/products/' + this.$route.params.id, {
			headers: {
				'token': localStorage.getItem('token')
			}
		}).then(response => {
			this.data = response.data;
			this.$store.dispatch('actionLoader');
			console.log(getImageURL(this.data.image));
		}).catch(() => {
			this.$router.push('/products');
		});
	},
	mounted() {
		for (let one in this.data.image) {
			console.log(one);
		}
		console.log(this.data.image);

	},
	methods: {
		// updateProduct() {
		// 	axios.patch(host + '/products/62', {
		// 		'name': 'test update vie Vue js'
		// 	}, {
		// 		headers: {
		// 			'accept': 'application/ld+json',
		// 			'Content-Type': 'application/merge-patch+json',
		// 			'token': localStorage.getItem('token')
		// 		}
		// 	}).then(() => {
		// 		alert('success');
		// 	}).catch(() => {
		// 		alert('error');
		// 	})
		// },
		deleteProduct(id) {
			axios.post(host +'/admin/delete-product/'+ id, {}, {
				headers: {
					'token': localStorage.getItem('token')
				}
			}).then(response => {
				this.$router.push('/products');
				console.log(response);
			}).catch(error => {
				this.message = 'Не удалось удалить продукт';
				// console.log('не удалось удалить продукт с id '+ id);
				// console.log(error);
			})
		},
		getImageURL
	}
}
</script>

<style lang="scss" scoped>
@import "src/assets/scss/color";
@import "src/assets/scss/message";

.product-view {
	display: grid;
	grid-gap: 10px;
	grid-template:
		"title image"
		"description image"
		"description price" 1fr
		/ 3fr 2fr;
}
.title {
	grid-area: title;
}
.description {
	grid-area: description;
}
.price {
	margin-top: 10px;
	grid-area: price;
}
.image {
	grid-area: image;
	width: 100%;
	margin: 0 auto;
}

@media all and (max-width: 800px){
	.product-view {
		background-color: $main-color;
		grid-template-columns: 1fr;
		grid-template-rows: 25px;
		grid-template:
			"title"
			"image" auto
			"price" 20px
			"description" auto
			/ 1fr;
	}
}
</style>
