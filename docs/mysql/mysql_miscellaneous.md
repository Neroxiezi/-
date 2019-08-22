# MySql 知识点记录

- 没有索引会让innoDb的行锁变为表锁

```mysql
    SET AUTOCOMMIT = 0; # 关闭自动提交
```

- 锁的范围越小越好

- 在查询的时候 禁止修改(悲观锁)

```mysql
    SELECT * FROM goods WHERE id=1 FOR UPDATE;
```

- 使用乐观锁来处理高并发下的商品下单

```mysql
    # 乐观锁 处理 加 一个版本号 version 版本号为0 的才可以购买
    UPDATE goods SET num = num-100,version=version+1 WHERE version=0 AND id=1;
```

- mysql读锁写锁

```mysql
    LOCK TABLE goods READ;
    LOCK TABLE goods WRITE;
    # 解锁
    UNLOCK TABLES;
```




