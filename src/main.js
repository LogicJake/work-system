import Vue from 'vue';
import App from './App';
import router from './router';
import axios from 'axios';
import JSZip from 'jszip';
import FileSaver from 'file-saver';
import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-default/index.css';    // 默认主题
import '../static/css/theme-green/index.css';       // 浅绿色主题
import '../static/font-awesome-4.7.0/css/font-awesome.min.css'; 
import "babel-polyfill";


Vue.use(ElementUI);
//axios.defaults.baseURL='http://g.gg'
Vue.prototype.$axios = axios;
Vue.prototype.$ajax = axios;
Vue.prototype.$domin = '';
new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
