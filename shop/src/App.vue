<template>
	<div class="search">
		<div class="logo">
			<router-link to="/">
				<p>GOOD</p>
				<p>LAVKA</p>
			</router-link>
		</div>
		<input type="text" placeholder="Поиск">
	</div>
	<router-view class="main" v-if="$store.state.auth"/>
  <div class="menu-mobile">
    <router-link to="/">Главная</router-link>
    <router-link to="/category">Категория</router-link>
    <router-link to="/favorites">Избранное</router-link>
    <router-link to="/cart">Корзина</router-link>
    <router-link to="/profile">Профиль</router-link>
  </div>
</template>

<script>
import Authentication from "@/service/auth/Authentication";

export default {
	name: 'App',
	async created() {
		await Authentication.authentication(this.$store).then(() => {
			console.log('authentication ok');
		}).catch(() => {
			console.log('authentication don\'t ok');
		});
	}
}
</script>

<style lang="scss">
* {
	padding: 0;
	margin: 0;
	font-size: 14px;
}
body {
	background-color: #f7f7f7;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.main {
	margin: 45px auto 80px auto;
	max-width: 1180px;
}
.search {
	position: fixed;
	display: flex;
	width: 100%;
	top: 0;

	.logo {
		flex: 1;
		a {
			text-decoration: none;
			color: #000;
		}
	}

	input {
		flex: 2;
		margin: 10px;
	}
}
.menu-mobile {
	width: 96%;
	position: fixed;
	bottom: 15px;
	left: 2%;
	background-color: #2FC537;
	padding: 20px 0;
	border-radius: 8px;
	display: flex;
	justify-content: space-around;

	a {
		text-decoration: none;
		color: #000;
		font-size: 12px;
	}
}

@media (max-width: 1260px) {
	.main {
		margin-left: 2%;
		margin-right: 2%;
	}
}
</style>
