// pages/product/product.js
import { Product } from '../product/product-model.js';
var product = new Product();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    countsArray: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    productCounts: 1,
    currentTabsIndex: 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // options 为传参
    var id = options.id;
    this._onLoad(id);
  },

  _onLoad: function(id) {
    product.getDetailInfo(id, (data) => {
      this.setData({
        product: data
      })
    })
  },

  bindPickerChange: function(event) {
    this.setData({
      productCounts: this.data.countsArray[event.detail.value],
    })
  },
  //切换详情面板
  onTabsItemTap: function (event) {
    var index = product.getDataSet(event, 'index');
    this.setData({
      currentTabsIndex: index
    });
  },
})