// 一个返回对象的匿名模块
define('mymath',[
    '_math',
], function(math) {
    //减法
    var subtraction = function(num1, num2) {
        return num1 - num2
    }
    return {
        add:math.add,
        sub:subtraction
    }
});