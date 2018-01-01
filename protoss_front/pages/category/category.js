
import { Category } from '../category/category-model.js';
var category = new Category();
// pages/category/category.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentMenuIndex: 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function () {
    this._loadData();
  },

  /*加载所有数据*/
  _loadData: function (callback) {
    var that = this;
    category.getCategoryType((categoryData) => {

      that.setData({
        categoryTypeArr: categoryData,
        loadingHidden: true
      });

      category.getProductsByCategory(categoryData[0].id, (data) => {
        var dataObj = {
          procucts: data,
          topImgUrl: categoryData[0].img.url,
          title: categoryData[0].name
        };
        that.setData({
          loadingHidden: true,
          categoryInfo0: dataObj
        });
        callback && callback();
      });
    });
  },

  changeCategory: function(event) {
    var index = category.getDataSet(event, 'index'),
    id = category.getDataSet(event, 'id');
    this.setData({
      currentMenuIndex : index
    });
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