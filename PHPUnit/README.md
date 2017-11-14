# phpunit learn demo 

PHPUnit
    
>   composer.json   composer文件
>   index.php       这是项目的入口文件


### *Assertions（断言)*

断言为PHPUnit的主要功能，用来验证单元的执行结果是不是预期值。

```html
    assertTrue(true);   # SUCCESSFUL
    assertEquals('orz', 'oxz', 'The string is not equal with orz');   #UNSUCCESSFUL
    assertCount(1, array('Monday'));   # SUCCESSFUL
    assertContains('PHP', array('PHP', 'Java', 'Ruby'));   # SUCCESSFUL
    assertTrue()：判断实际值是否为true。
    assertEquals()：预期值是orz，实际值是oxz，因为两个值不相等，所以这一个断言失败，会显示The string is not equal with orz的字串。
    assertCount()：预期数组大小为1。
    assertContains()：预期数组中有一个PHP字串的元素存在。
```

   