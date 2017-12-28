
import { Base } from '../../utils/base';

class Home extends Base {
  constructor() {
    super();
  }

  getBannerData(id, callback) {
    var params = {
      url: 'banner/' + id,
      sCallBack: function(res) {
        callback&&callback(res.items);
      }
    };
    this.request(params);    
  }

  // 首页主题
  getThemeData(callback) {
    var params = {
      url: 'theme?ids=1,2,3',
      sCallBack: function(res) {
        callback&&callback(res);
      }
    };
    this.request(params);    
  }

  /*首页部分商品*/
  getProductorData(callback) {
    var param = {
      url: 'product/recent',
      sCallBack: function (data) {
        callback && callback(data);
      }
    };
    this.request(param);
  }
}

export { Home };