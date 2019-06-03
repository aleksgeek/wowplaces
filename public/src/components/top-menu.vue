<template>
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand"> 
                    <img src="img/logo.png"> 
                </a>

                <ul class="nav pull-left visible-xs">
                    <li v-bind:class="{ open: isMenuOpen }">
                        <a href="#" class="menu-a" v-on:click="toggleMenu()">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>     
        
                <div class="hidden-xs pull-left">
                    <ul class="nav navbar-nav">
                      <li><router-link to="/add-place" class="menu-a">добавить</router-link></li>
                      <li><router-link to="/places-map" class="menu-a">карта</router-link></li>
                      <li><router-link to="/tourist-guide" class="menu-a">путеводитель туриста</router-link></li>
                    </ul>
                </div>
                
                <ul class="nav pull-right">
                    <li v-bind:class="{ open: openForm }">
                        <a href="#" class="menu-a menu-a-auth pull-right" v-on:click="toggleAuthForm()">
                            <span v-if="!isLogined">войти/регистрация</span>
                            <span v-if="isLogined">{{auth.userData.name}}</span>
                            <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                        </a>
                        <div class="auth-form" v-if="!isLogined && openForm">
                            <form method="post" @submit.prevent="authenticate()">
                                <div class="form-group">
                                    <label for="email">Ваш email</label>
                                    <input class="form-control" type="email" name="email" v-model="auth.email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Ваш пароль</label>
                                    <input class="form-control" type="password" name="password" v-model="auth.password" required>
                                </div>
                                <div class="error" v-if="loginError">некорректный логин или пароль</div>
                                <button type="submit" class="btn btn-success btn-sm">войти</button>

                                <router-link to="/registration" class="btn btn-primary btn-sm" v-on:click="toggleAuthForm()">регистрация</router-link>
                            </form>
                        </div> 
                        <div class="auth-form" v-if="isLogined && openForm">
                          <div>
                            {{ auth.userData.email }}
                          </div>    
                          <hr>
                          <button type="button" class="btn btn-success" v-on:click="logout()">выйти</button>
                        </div>                                                                  
                    </li>
                </ul>
                          
            </div> 
            <div v-if="isMenuOpen" class="mobile-menu visible-xs" v-on:click="toggleMenu()">
                <ul class="nav navbar-nav">
                  <li><router-link to="/add-place" class="menu-a">добавить</router-link></li>
                  <li><router-link to="/places-map" class="menu-a">карта</router-link></li>
                  <li><router-link to="/tourist-guide" class="menu-a">путеводитель туриста</router-link></li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import axios from 'axios';
    import AuthService from '../services/AuthService.js';

    export default {
      data () {
        return {
          isMenuOpen: false,
          openForm: false,
          isLogined: false,
          loginError: false,
          auth:{
            email: '',
            password: '',
            userData: ''
          }
        }
      },
      methods: {
        toggleMenu: function(){
          this.isMenuOpen = !this.isMenuOpen;
        },
        toggleAuthForm: function(){
          this.openForm = !this.openForm;
        },
        authenticate: function(){
          var self = this;

            axios.post(process.env.API_URL+'/authenticate', {
                email: self.auth.email, 
                password: self.auth.password
            }).then(function (response) {
              AuthService.saveUserDataFromResponse(response);

              self.isLogined = AuthService.isLogined();  
              self.auth.userData = AuthService.getAuthUser();
              self.toggleAuthForm();
            }).catch(function (error) {
              console.log(error);
            });
        },
        logout: function(){
          AuthService.logout();
          window.location.reload();
        }
      }
    }
</script>