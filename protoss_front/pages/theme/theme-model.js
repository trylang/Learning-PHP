import { Base } from '../../utils/base.js';

class Theme extends Base {
   constructor () {
     super();
   }
   getProductData(id, callback) {
     var param = {
       url: 'theme/' + id,
       sCallBack: function(res) {
         callback&&callback(res);
       }
     };
     this.request(param);
   }
}

export { Theme };