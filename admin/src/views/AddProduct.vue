<template>
  <div>
	  <h1>Add Product</h1>
	  <form id="formAddProduct" class="form" @submit.prevent="addProduct()">
		  <input type="text" placeholder="Название" v-model.lazy="name">
		  <textarea name="" cols="30" rows="10" placeholder="Описание" v-model.lazy="description"></textarea>
		  <input type="text" placeholder="Цена" v-model.lazy="price">
		  <input type="file" ref="file" multiple v-on:change="handleFiles()">
		  <button>Отправить</button>
	  </form>
	  <div class="message" v-if="result">
		  <p>{{ result }}</p>
	  </div>
	  <div class="message" v-if="imageError.length != 0">
		  <p class="error" v-for="error in imageError">
			  Не верный формат файла "{{ error }}"
		  </p>
		  <p class="error">
			  Возможные форматы только jpg, png, webp
		  </p>
	  </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from '../service/host';

export default {
  name: 'AddProduct',
	data() {
  	return {
  		name: '',
		  description: '',
		  price: '',
		  base64Images: [],
		  imageError: [],
		  result: ''
	  }
	},
  components: {
  },
	mounted() {
		if (!this.$store.getters.getLoginIn) {
			this.$router.push('/login');
		}
		this.$store.dispatch('actionLoader');
	},
	methods: {
  	handleFiles() {
			this.base64Images = [];
			this.imageError = [];

			/* ========= Обработка изображения ========= */
			let imageFiles = this.$refs.file.files;
			for (let i = 0; i < imageFiles.length; i++) {
				if (imageFiles[i].type === 'image/jpeg' || imageFiles[i].type === 'image/png'
				|| imageFiles[i].type === 'image/webp') {
					let fr = new FileReader();
					fr.onload = () => {
						let image = new Image();
						image.onload = () => {
							let w, h, one, two, ctx, canv;
							canv = document.createElement('canvas');
							if (image.naturalWidth > image.naturalHeight) {
								w = image.naturalHeight;
								h = image.naturalHeight;
								canv.width = w ;
								canv.height = h;
								ctx = canv.getContext("2d");
								one = (image.naturalWidth - image.naturalHeight) / 2;
								ctx.drawImage(image, one, 0, w, h, 0, 0, w, h);
							} else if (image.naturalWidth < image.naturalHeight) {
								w = image.naturalWidth;
								h = image.naturalWidth;
								canv.width = w ;
								canv.height = h;
								ctx = canv.getContext("2d");
								two = (image.naturalHeight - image.naturalWidth) / 2;
								ctx.drawImage(image, 0, two, w, h, 0, 0, w, h);
							} else {
								w = image.naturalWidth;
								h = image.naturalHeight;
								canv.width = w ;
								canv.height = h;
								ctx = canv.getContext("2d");
								ctx.drawImage(image, 0,0);
							}
							this.base64Images.push(canv.toDataURL('image/jpeg'));
						}
						image.src = fr.result;
					}
					fr.readAsDataURL(imageFiles[i]);
				} else {
					this.imageError.push(imageFiles[i].name);
					continue;
				}
			}
			/* ========= Обработка изображения ========= */
	  },
  	addProduct() {
			let form = new FormData();
  		form.append('name', this.name);
  		form.append('description', this.description);
  		form.append('price', this.price);
			for (let i = 0; i < this.base64Images.length; i++) {
				form.append('image['+ i +']', this.base64Images[i]);
			}

  		axios.post(host + '/admin/load-product', form, {
  			headers: {
				  'Content-Type': 'multipart/form-data',
				  'token': localStorage.getItem('token')
			  }
		  }).then(response => {
					this.result = 'Данные загружены';
		      console.log(response);
	    }).catch(error => {
			  this.result = 'Ошибка при загрузке данных';
			  console.log(error);
	    });
	  }
	}
}
</script>

<style lang="scss">
.form {
	display: inline-grid;
}
.error {
	color: #dc6a23;
	margin: 3px 0;
}
.message {
	margin-top: 10px;
	font-size: .9em;
}
</style>
