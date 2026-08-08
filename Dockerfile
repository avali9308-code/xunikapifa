# PHP 8.2 + Apache 官方镜像（自带 SQLite，不用额外装）
FROM php:8.2-apache

# 1. 开启伪静态 + 强制显示PHP错误（失败了会告诉你原因，不会一片空白）
RUN a2enmod rewrite headers \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "log_errors = On" >> /usr/local/etc/php/conf.d/errors.ini

# 2. 先强制创建 data 目录（GitHub 不传空文件夹，这里兜底创建）
RUN mkdir -p /var/www/html/data \
    && chown -R www-data:www-data /var/www/html/data \
    && chmod -R 777 /var/www/html/data

# 3. 把你所有网站代码拷进服务器
COPY . /var/www/html/

# 4. 最后再全局设一遍权限（确保数据库文件能正常读写，不会报错）
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/data \
    && touch /var/www/html/data/shop.db \
    && chmod 666 /var/www/html/data/shop.db

# 5. 适配 Render 随机端口（防止 502 Bad Gateway）
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# 6. 启动网站
CMD ["start.sh"]
