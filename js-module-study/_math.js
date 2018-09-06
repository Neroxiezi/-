//一个没有依赖性的模块可以直接定义对象

define({
    name:'测试名字',
    add: function(num1, num2) {
        return num1 + num2
    }
});