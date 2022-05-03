import axios from "axios";
import {host} from "@/service/host";


export default class Authentication
{

  static async authentication() {
    if (!localStorage.getItem('shop-token')) {
      await this.registerGuest();
    } else {
      await this.checkToken();
    }
  }

  static async registerGuest() {
    axios.get(host + '/register-guest').then(response => {
      localStorage.setItem('shop-token', response.headers['shop-token']);
    }).catch(() => {
      console.log('Что-то пошло не так с регистрацией гостя');
    })
  }

  static async checkToken() {
    await axios.get(host + '/check-token', {
      headers: {
        'shop-token': localStorage.getItem('shop-token')
      }
    }).then(response => {
      console.log(response.data);
    }).catch(() => {
      this.registerGuest();
    })
  }
}
