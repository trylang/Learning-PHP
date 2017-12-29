import { Base } from '../../utils/base.js';

class Product extends Base {
  constructor() {
    super();
  }

  getDetailInfo(id, callback) {
    var param = {
      url: 'product/' + id,
      sCallBack: function(res) {
        callback && callback(res);
      }
    };
    this.request(param);
  }
}

export { Product };