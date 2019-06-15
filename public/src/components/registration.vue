<template>
    <div class="container top-10">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                <div v-if="!isRegistered">
                    <form method="post" @submit.prevent="save()">
                        <div class="form-group">
                            <label for="name">Ваше имя</label>
                            <input class="form-control" type="text" name="name" v-model="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Ваш email</label>
                            <input class="form-control" type="email" name="email" v-model="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Ваш пароль</label>
                            <input class="form-control" type="password" name="password" v-model="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Подтвердите пароль</label>
                            <input class="form-control" type="password" name="password-confirmation" v-model="passwordConfirmation" required>
                        </div>
                        <div class="error-txt" v-if="isError">Ошибка регистрации</div>
                        <button type="submit" class="btn btn-success">Регистрация</button>  
                    </form> 
                </div> 
                <div v-if="isRegistered">
                    Вам было отправлено на почту письмо, для подтверждения регистрации перейдите по ссылке указанной в письме. 
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
  export default {
    data () {
      return { 
        isRegistered: false,
        isError: false,
        errors: [],
        name: null,
        email: null,
        password: null,
        passwordConfirmation: null
      }
    },

    methods: {
        save() {
            this.checkForm();
        },

        checkForm() {
            console.log(this.name);
            console.log(this.email);
            console.log(this.password);
        }
    }
  }
</script>