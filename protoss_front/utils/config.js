/**
 * 
 *  配置文件写成了类，但如何做到不用在其他地方实例化它呢,直接静态调用？
 *  直接在class外部定义
 */

 class Config {
   constructor() {

   }
 }

 Config.restUrl = 'http://z.cn/api/v1/';

 export { Config };
