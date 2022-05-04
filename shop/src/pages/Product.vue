<template>
  <div class="product-view">
	  <div class="slider">
		  <div class="slider__wrapper">
			  <div class="slider__items">
				  <div class="slider__item" v-for="img in images">
					  <img :src="host + '/images' + img" alt="" loading="lazy">
				  </div>
			  </div>
		  </div>
		  <a class="slider__control slider__control_prev" href="#" role="button" data-slide="prev"></a>
		  <a class="slider__control slider__control_next" href="#" role="button" data-slide="next"></a>
	  </div>

<!--	  <img-->
<!--		  v-for="img in images"-->
<!--		  :src="host + '/images' + img"-->
<!--		  :alt="data.name"-->
<!--		  loading="lazy">-->
	  <h1 class="product-name">{{ data.images }}</h1>
	  <p class="description">{{ data.description }}</p>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";
import {getImage} from "@/service/getImagesForSlider";
import SimpleAdaptiveSlider from "@/service/SliderAdaptive/SimpleAdaptiveSlider";

export default {
	name: 'Product',
	data() {
		return {
			data: [],
			host: host,
			images: []
		}
	},
	async mounted() {
		await axios.get(host + '/shop/product/' + this.$route.params.id, {
			headers: {
				'shop-token': localStorage.getItem('shop-token')
			}
		})
			.then(response => {
				this.data = response.data;
				this.images = getImage(this.data.image, 1);
			}).catch(error => {
				console.log(error);
			});

		new SimpleAdaptiveSlider('.slider', {
			loop: false,
			autoplay: false,
			swipe: true
		});
	}
}
</script>

<style lang="scss">
@import "/src/service/SliderAdaptive/slider-adaptive";

.product-view {
	display: grid;
	grid-template:
	"image name"
	"description description"
	/ 2fr 3fr;
	grid-gap: 15px;
	.slider {
		grid-area: image;
		width: 100%;
	}
	.product-name{
		grid-area: name;
	}
	.description {
		grid-area: description;
	}
	img {
		width: 100%;
		object-fit: cover;
	}
}
@media (max-width: 600px) {
	.product-view {
		grid-template:
			"image"
			"name"
			"description"
			;
	}
}
</style>
