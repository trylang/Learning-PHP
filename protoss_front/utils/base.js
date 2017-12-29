import { Config } from '../utils/config';
class Base {

  constructor() {
    this.baseRequestUrl = Config.restUrl
  }

  request(params) {
    var url = this.baseRequestUrl + params.url;
    if(!params.type) {
      params.type = 'GET';
    }
    wx.request({
      url: url,
      data: params.data,
      method: params.type,
      header: {
        'content-type' : 'application/json',
        'token': wx.getStorageSync('token')
      },
      success: function(res) {

        // 需判断函数是否为空
        params.sCallBack&&params.sCallBack(res.data);
      },
      fail: function(err) {
        console.log(err);
      }
    })
  }
  
  // 获取元素上绑定的值
  getDataSet(event, key) {
    return event.currentTarget.dataset[key];
  }
     
}

export {Base};

  