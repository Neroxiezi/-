# CSRF 攻击解析

### A 网站是正常登录网站
```
A
|
|-- login.html 登录页面
|-- login.php 登录流程
|-- data.json  数据库文件
|-- csrf_demo.php 这个是修改用户名的文件 也是被用来进行csrf攻击的文件
|-- set_username.php 是修改用户名的正常的页面
----

B 是用来构建攻击的网站
|
|--index.php 
```
