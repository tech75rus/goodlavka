<template>
  <div class="profile">
    <h1>Профиль</h1>
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
  }
}
</script>