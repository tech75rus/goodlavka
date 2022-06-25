<template>
  <div class="profile">
    <h1>Гость</h1>
    <div class="profile_container border" v-for="payment in payments" :key="payment.id_yookassa">
      <div class="profile_main">
        <h2>Заказ №</h2>
        <p>{{payment.id_yookassa}}</p>
        <h2>Сумма</h2>
        <p>{{payment.price}} руб</p>
        <span class="profile_main_detail" @click="showHidden">Дополнительная информация</span>
      </div>
      <div class="profile_detail" v-for="detail in payment.paymentDetails">
        <div class="profile_detail_image">
          <img :src="host + '/images' + getImageURL(detail.id_product.image, 3)">
        </div>
        <div class="profile_detail_text">
          <h2>Наименование</h2>
          <p>{{detail.name}}</p>
          <h2>Цена</h2>
          <p>{{detail.price}} руб</p>
          <h2>Количество</h2>
          <p>{{detail.count}} шт</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";
import {getImageURL} from "@/service/getImageURL";

export default {
  name: 'Profile',
  data() {
    return {
      host: host,
      payments: ''
    }
  },
  created() {
    axios.get(host + '/shop/profile', {
      headers: {
        'shop-token': localStorage.getItem('shop-token')
      }
    }).then(response => {
      console.log(response);
      this.payments = response.data.payments
    }).catch(error => {
      console.log(error);
    })
  },
  methods: {
    showHidden(event) {
      let main = event.target.parentElement.parentElement;
      let profileDetail = main.querySelectorAll('.profile_detail');
      let firstElement = profileDetail[0].style.display;
      if (firstElement === '' || firstElement === 'none') {
        for (let detail of profileDetail) {
          detail.style.display = 'grid';
        }
      } else {
        for (let detail of profileDetail) {
          detail.style.display = 'none';
        }
      }
    },
    getImageURL
  }
}
</script>

<style lang="scss" scoped>
@import "src/assets/scss/border";

.profile_container {
  margin-top: 20px;
}
.profile_main {
  display: grid;
  gap: 10px 0;
  grid-template-columns: 1fr 1fr;
  justify-items: start;
}
.profile_main_detail {
  grid-column: 1 / 3;
  cursor: pointer;
  color: #229426;
}
.profile_detail {
  display: none;
  grid-template-columns: auto 1fr;
  justify-items: start;
  margin-top: 25px;
}
.profile_detail_text {
  display: grid;
  grid-template-columns: 1fr 1fr;
  justify-items: start;
  width: 100%;
}
.profile_detail_image {
  margin-right: 15px;
  width: 70px;
  min-height: 70px;
  img {
    width: 70px;
  }
}
</style>