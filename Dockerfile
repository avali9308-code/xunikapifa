# PHP 8.2 + Apache 官方镜像（自带 SQLite，不用额外装）
FROM php:8.2-apache

# 开启伪静态，防止页面404
RUN a2enmod rewrite headers

# 拷贝网站代码
COPY . /var/www/html/

# 设置目录权限（关键！不然数据库写不进去）
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/data

# 适配Render随机端口，防止502报错
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# 启动网站
CMD ["start.sh"]
