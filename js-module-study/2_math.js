// 一个使用了简单的CommonJS转换的模块定义
define(function(require,exports,module) {
    var math = require('_math');
    console.log(math)
    //导出（暴露方法：2种方式）
    // exports.a = math.add;
    module.exports = {
        a : math.add
    }
});