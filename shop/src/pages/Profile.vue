<template>
  <div class="profile">
    <h1>Гость</h1>
    <div class="profile_container border">
      <div class="profile_main">
        <h2>Заказ №</h2>
        <p>6261</p>
        <h2>Сумма</h2>
        <p>234 руб</p>
        <span class="profile_main_detail" @click="showHidden(this)">Дополнительная информация</span>
      </div>
      <div class="profile_detail">
        <div class="profile_detail_image">
          <img src="../../public/test/150x150-629cc44d7c717.webp">
        </div>
        <div class="profile_detail_text">
          <h2>Наименование</h2>
          <p>Футболка</p>
          <h2>Цена</h2>
          <p>77 руб</p>
          <h2>Количество</h2>
          <p>2 шт</p>
        </div>
      </div>
      <div class="profile_detail">
        <div class="profile_detail_image">
          <img src="../../public/test/150x150-629cc44d7c717.webp">
        </div>
        <div class="profile_detail_text">
          <h2>Наименование</h2>
          <p>Футболка</p>
          <h2>Цена</h2>
          <p>77 руб</p>
          <h2>Количество</h2>
          <p>2 шт</p>
        </div>
      </div>
    </div>
    <div class="profile_container border">
      <div class="profile_main">
        <h2>Заказ №</h2>
        <p>6261</p>
        <h2>Сумма</h2>
        <p>234 руб</p>
        <span class="profile_main_detail" @click="showHidden(even)">Дополнительная информация</span>
      </div>
      <div class="profile_detail">
        <div class="profile_detail_image">
          <img src="../../public/test/150x150-629cc44d7c717.webp">
        </div>
        <div class="profile_detail_text">
          <h2>Наименование</h2>
          <p>Футболка</p>
          <h2>Цена</h2>
          <p>77 руб</p>
          <h2>Количество</h2>
          <p>2 шт</p>
        </div>
      </div>
      <div class="profile_detail">
        <div class="profile_detail_image">
          <img src="../../public/test/150x150-629cc44d7c717.webp">
        </div>
        <div class="profile_detail_text">
          <h2>Наименование</h2>
          <p>Футболка</p>
          <h2>Цена</h2>
          <p>77 руб</p>
          <h2>Количество</h2>
          <p>2 шт</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {host} from "@/service/host";

export default {
  name: 'Profile',
  data() {
    return {
      //host: ''
    }
  },
  created() {
    axios.get(host + '/shop/profile', {
      headers: {
        'shop-token': localStorage.getItem('shop-token')
      }
    }).then(response => {
      console.log(response);
    }).catch(error => {
      console.log(error);
    })
  },
  methods: {
    showHidden(event) {
      console.log(event.target);
    }
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
  grid-template-columns: 1fr 1fr;
  justify-items: start;
}
.profile_main_detail {
  grid-column: 1 / 3;
  cursor: pointer;
  color: #229426;
}
.profile_detail {
  display: grid;
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
  img {
    width: 70px;
  }
}
</style>