import axios from "axios";
import {host} from "@/service/host";

export default class Authentication
{

  static async authentication(store) {
    if (!localStorage.getItem('shop-token')) {
      await this.registerGuest(store);
    } else {
      await this.checkToken(store);
    }
  }

  static async checkToken(store) {
    await axios.get(host + '/check-token', {
      headers: {
        'shop-token': localStorage.getItem('shop-token')
      }
    }).then(() => {
      store.commit('changeAuth');
    }).catch(() => {
      this.registerGuest(store);
    })
  }

  static async registerGuest(store) {
    await axios.get(host + '/register-guest').then(response => {
      localStorage.setItem('shop-token', response.headers['shop-token']);
      store.commit('changeAuth');
    }).catch(() => {
      console.log('Что-то пошло не так с регистрацией гостя');
    })
  }
}
