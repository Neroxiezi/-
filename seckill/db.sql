USE seckill;
CREATE  TABLE  IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` INT NOT NULL,
    `store` INT NOT NULL,
    `detail` VARCHAR(255) NOT NULL DEFAULT ''
)ENGINE=InnoDB CHARSET=utf8

INSERT INTO `products`(`name`,`price`,`store`,`detail`) VALUES ('PF大礼包',1,2,'PF抢购')
SELECT * from products