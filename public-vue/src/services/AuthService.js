import axios from 'axios';

export default {
  saveUserDataFromResponse(response){
    var token    = response.data;
    var tokenArr = token.split('.');
    var dataObj  = atob(tokenArr[1]);
    
    sessionStorage.setItem('userData', dataObj);
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