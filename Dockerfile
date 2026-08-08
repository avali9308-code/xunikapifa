# 用官方 PHP 8.2 + Apache 镜像（我们的代码完美适配）
FROM php:8.2-apache

# 1. 开启 SQLite 数据库扩展（你网站用的数据库）
RUN docker-php-ext-install pdo_sqlite

# 2. 开启 Apache 伪静态（防止页面 404）
RUN a2enmod rewrite headers

# 3. 把你所有网站代码拷进服务器
COPY . /var/www/html/

# 4. 设置目录权限（不然 SQLite 写不进数据、会报错）
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/data

# 5. 拷启动脚本（适配 Render 的随机端口，防止 502 报错）
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# 6. 启动网站
CMD ["start.sh"]
