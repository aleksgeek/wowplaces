<template>
  <div class="top-menu">
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div>
            <div class="navbar-header">
                <a href="#" class="navbar-brand"> 
                    <img src="img/logo.png"> 
                </a>

                <ul class="nav pull-left visible-xs">
                    <li :class="{ open: isMenuOpened }">
                        <a href="#" class="menu-a" @click="toggleMenu()">
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
                
                <ul class="nav pull-right auth-block">
                    <li :class="{ open: isAuthFormOpened }">
                        <a href="#" class="menu-a menu-a-auth pull-right" @click="toggleAuthForm()">
                            <span v-if="!isLogined">войти/регистрация</span>
                            <span v-if="isLogined">{{userData.name}}</span>
                            <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                        </a>
                        <div class="auth-form" v-if="!isLogined && isAuthFormOpened">
                            <form method="post" @submit.prevent="authenticate()">
                                <div class="form-group">
                                    <label for="email">Ваш email</label>
                                    <input class="form-control" type="email" name="email" v-model="formData.email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Ваш пароль</label>
                                    <input class="form-control" type="password" name="password" v-model="formData.password" required>
                                </div>
                                <show-errors :errors="errors"></show-errors>
                                <button type="submit" class="btn btn-success btn-sm" :disabled="isEnterBtnDisabled">войти</button>
                                <router-link to="/registration" class="btn btn-primary btn-sm" @click="toggleAuthForm()">регистрация</router-link>
                            </form>
                        </div> 
                        <div class="auth-form" v-if="isLogined && isAuthFormOpened">
                          <div> <b>Email:</b>{{ userData.email }} </div>    
                          <hr>
                          <button type="button" class="btn btn-success" @click="logout()">выйти</button>
                        </div>                                                                  
                    </li>
                </ul>
                          
            </div>
            <div v-if="isMenuOpened" class="mobile-menu visible-xs" @click="toggleMenu()">
                <ul class="nav navbar-nav">
                  <li><router-link to="/add-place" class="menu-a">добавить</router-link></li>
                  <li><router-link to="/places-map" class="menu-a">карта</router-link></li>
                  <li><router-link to="/tourist-guide" class="menu-a">путеводитель туриста</router-link></li>
                </ul>
            </div>
        </div>
    </nav>
  </div>  
</template>

<script>
  import AuthService from '../services/AuthService.js';
  import ShowErrors from './common/show-errors.vue'

    export default {
      mounted() {
        var self = this;

        document.addEventListener('click', function (e) {
          ///console.log(e);
          if(self.isAuthFormOpened){
            ///self.toggleAuthForm();  
          }
          
          if(self.isMenuOpened){
            ///self.toggleMenu();  
          }          
        });
      },
      data () {
        return {
          isMenuOpened: false,
          isAuthFormOpened: false,
          isLogined: false,
          isEnterBtnDisabled: false,
          errors: [],
          formData:{
            email: null,
            password: null,
          },
          userData: null,
        }
      },
      methods: {
        toggleMenu: function(){
          this.isMenuOpened = !this.isMenuOpened;
        },
        toggleAuthForm: function(){
          this.isAuthFormOpened = !this.isAuthFormOpened;
        },
        authenticate: function(){
          let self = this;
          self.errors = [];
          self.isEnterBtnDisabled = true;

          AuthService.authenticate(self.formData).then(function (response) {
            AuthService.saveUserDataFromResponse(response);
            
            self.isLogined = AuthService.isLogined();  
            self.userData  = AuthService.getAuthUser();
            self.isAuthFormOpened = false;
          }).catch(function (err) {
            let errors = err.response.data;

            if(typeof errors === 'string'){
              self.errors.push(errors);
            }

            self.isEnterBtnDisabled = false;
          });
        },
        logout: function(){
          AuthService.logout();
          window.location.reload();
        }
      },
      components: {
        ShowErrors
      }
    }
</script>