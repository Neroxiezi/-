# js 模块化编程

#### 模块化开发的演变过程

1.全局函数

```javascript

function add(a , b) {
    return parseFloat(a) + parseFloat(b);
}
function substract(a ,b) {}
function multiply(a ,b) {}
function divide(a ,b) {}

```

在早期的开发过程中就是将重复的代码封装到函数中，再将一系列的函数放到一个文件中，这种情况下全局函数的方式只能认为的认为它们属于一个模块，但是程序并不能区分哪些函数是同一个模块，如果仅仅从代码的角度来说，这没有任何模块的概念。

存在的问题:

> 污染了全局变量，无法保证不与其他模块发生变量名冲突。

>模块成员之间看不出直接关系。


2.对象封装-命名空间

```javascript

    var calculator = {
      add: function(a, b) {
        return parseFloat(a) + parseFloat(b);
      },
      subtract: function(a, b) {},
      multiply: function(a, b) {},
      divide: function(a, b) {}
    };
```

通过添加命名空间的形式从某种程度上解决了变量命名冲突的问题，但是并不能从根本上解决命名冲突。 不过此时从代码级别可以明显区分出哪些函数属于同一个模块。


存在的问题：

> 暴露了所有的模块成员，内部状态可以被外部改写，不安全。

> 命名空间越来越长。

3.私有公有成员分离

```javascript

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

```
4.模块的扩展与维护

```javascript

(function(){
    function convert(input) {
        return parseInt(input);
    }

    calculator.add = function(a,b) {
        return convert(a) + convert(b)
    }
    window.calculator = calculator
})(window.calculator || {})

// 新增需求
(function (calculator) {
    calculator.remain = function (a , b) {
        return a % b;
    }
    window.calculator = calculator;
})(window.calculator || {});
alert(calculator.remain(4,3));

```

>利用此种方式，有利于对庞大的模块的子模块划分。

>实现了开闭原则：对新增开发，对修改关闭。对于已有文件尽量不要修改，通过添加新文件的方式添加新功能。

5. 第三方依赖的管理

```javascript   
    (function (calculator , $) {
    // 依赖函数的参数，是属于模块内部
    // console.log($);
    calculator.remain = function (a , b) {
        return a % b;
    }
    window.calculator = calculator;
})(window.calculator || {} , jQuery);

```

>模块最好要保证模块的职责单一性，最好不要与程序的其他部分直接交互，通过向匿名函数注入依赖项的形式，除了保证模块的独立性，还使模块之间的以来关系变得明显。
>对于模块的依赖通过自执行函数的参数传入，这样做可以做到依赖抽象，本例中使用的jQuery，而当要使用zepto的时候，只要更换传入的参数即可。
>原则：高内聚低耦合，模块内相关性高，模块间关联低。



