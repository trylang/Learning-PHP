import { Home } from 'home-model.js';

// 因为HOme创建的是类，需要new一下，出现实例才可用其中方法
var home = new Home();

// pages/home/home.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._onLoad();
  },

  _onLoad: function(id) {
    var id = 1;
    home.getBannerData(id, (res) => {
      this.setData({
        'bannerArr': res
      });
    });

    home.getThemeData((res) => {
      this.setData({
        'themeArr': res
      });
    });

    home.getProductorData((res) => {
      this.setData({
        'productsArr': res
      });
    });
  },

  onProductsItemtap: function(event) {
    // Base类已经被home-model引入，所以可直接home调用方法
    var id = home.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id
    })
  },

  /*跳转到主题列表*/
  onThemesItemTap: function (event) {
    var id = home.getDataSet(event, 'id');
    var name = home.getDataSet(event, 'name');
    wx.navigateTo({
      url: '../theme/theme?id=' + id + '&name=' + name
    })
  }
})