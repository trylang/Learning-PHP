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
    console.log(event);
    var id = null;
    wx.navigateTo({
      url: '../product/product?id' + id
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})