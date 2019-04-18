<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./node_modules/layui-src/dist/css/layui.css">
    <script src="node_modules/layui-src/dist/layui.js"></script>
</head>
<body>
<table id="demo" lay-filter="test"></table>
<script>
    layui.use('table', function () {
        var table = layui.table;
        table.render({
            elem: '#demo'
            , height: 312
            , url: './data.php' //数据接口
            , page: true //开启分页
            , cols: [[ //表头
                {field: 'id', title: 'ID', width: 80, sort: true, fixed: 'left'}
                , {field: 'username', title: '用户名', width: 80}
                , {field: 'sex', title: '性别', width: 80, sort: true}
                , {field: 'city', title: '城市', width: 80}
                , {field: 'sign', title: '签名', width: 177}
                , {field: 'experience', title: '积分', width: 80, sort: true}
                , {field: 'score', title: '评分', width: 80, sort: true}
                , {field: 'classify', title: '职业', width: 80}
                , {field: 'wealth', title: '财富', width: 135, sort: true}
            ]]
        });
        var i = 0;
        setTimeout(function () {
            table.reload('demo');
            i++;
            console.log(i);
        }, 2000)
    })
</script>
</body>
</html>