import axios from 'axios';

export default {
  saveUserDataFromResponse(response){
    var token    = response.data;
    var tokenArr = token.split('.');
    var dataObj  = atob(tokenArr[1]);
    
    sessionStorage.setItem('userData', dataObj);
  },
  register: function(data) {
    return axios.post(process.env.API_URL+'/register', {
      name:data.name, 
      email:data.email, 
      password:data.password, 
      password_confirmation:data.passwordConfirmation
    });
  },
  sendAuthApproveCode: function(email) {
    return axios.post(process.env.API_URL+'/register/mail', { 
      recipient_email:email
    });
  },
  authenticate: function(data) {
    return axios.post(process.env.API_URL+'/authenticate', {
      email: data.email, 
      password: data.password
    });
  },
  isLogined(){
    return !!this.getAuthUser();
  },
  getAuthUser(){
    return JSON.parse(sessionStorage.getItem('userData'));
  },
  logout(){
    return sessionStorage.removeItem('userData');
  }
}