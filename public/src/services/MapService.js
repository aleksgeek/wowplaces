import axios from 'axios';

export default {
  topIndent: 30,
  getAllObjects(){
    return axios.get(process.env.API_URL+'/objects');
  }
}