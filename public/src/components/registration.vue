<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                <div>
                    <form method="post" @submit.prevent="save()">
                        <div class="form-group">
                            <label for="name">Ваше имя</label>
                            <input class="form-control" type="text" name="name" v-model="formData.name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Ваш email</label>
                            <input class="form-control" type="email" name="email" v-model="formData.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Ваш пароль</label>
                            <input class="form-control" type="password" name="password" v-model="formData.password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Подтвердите пароль</label>
                            <input class="form-control" type="password" name="password-confirmation" v-model="formData.passwordConfirmation" required>
                        </div>
                        <show-errors :errors="errors"></show-errors>
                        <div class="success-txt" v-if="isRegistered">
                            Вам было отправлено на почту письмо, для подтверждения регистрации перейдите по ссылке указанной в письме. 
                        </div>                        
                        <button type="submit" class="btn btn-success" :disabled="isRegisteredBtnDisabled">Регистрация</button>  
                    </form> 
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
  import AuthService from '../services/AuthService.js';
  import ShowErrors from './common/show-errors.vue'

  export default {
    data () {
      return {
        isRegisteredBtnDisabled: false,
        isRegistered: false,
        errors: [],
        formData: {
          name: null,
          email: null,
          password: null,
          passwordConfirmation: null,
        }
      }
    },

    methods: {
        save() {
          let self = this;
          self.errors = [];
          self.isRegisteredBtnDisabled = true;

          AuthService.register(self.formData).then(function (response) {
            return AuthService.sendAuthApproveCode(self.formData.email);
          }).then(function (response) {
            console.log(response.data); /// TODO - just for testing, remove it later
            self.isRegistered = true;
          }).catch(function (err) {
            let errors = err.response.data.errors;

            for (const key in errors) {
              if (errors.hasOwnProperty(key)) {
                self.errors = self.errors.concat(errors[key]);
              }
            }

            self.isRegisteredBtnDisabled = false;
          }); 
        },
    },

    components: {
      ShowErrors
    }    
  }
</script>