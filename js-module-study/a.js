// function doSomething() {
//     const a = 10;
//     const b = 11;
//     const add = function () {
//         return a + b
//     }
//
//     alert(add(a + b))
// }
//
// doSomething()



function add(a,b) {
    return parseFloat(a) + parseFloat(b);
}

function substract(a ,b) {}
function multiply(a ,b) {}
function divide(a ,b) {}


var calculator = {
    add :function (a,b) {
        return parseFloat(a) + parseFloat(b)
    },
    substract:function (a,b) {

    },
}

var calculator = (function(){
    //这里形成一个单独的私有的空间
    // 私有成员的作用
    // 1.将一个成员私有化
    // 2. 抽象公共方法(其他成员会用到))

    function convert(input){
        return parseInt(input)
    }

    function add(a,b) {
        return convert(a) + convert(b)
    }
    return {
        add:add,
        substract:function(a,b){}
    }
})();


(function(){
    function convert(input) {
        return parseInt(input);
    }

    calculator.add = function(a,b) {
        return convert(a) + convert(b)
    }
    window.calculator = calculator
})(window.calculator || {})
