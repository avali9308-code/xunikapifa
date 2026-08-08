#!/bin/bash
# 自动适配 Render 给的端口（Render 每次都会给一个随机端口，不能写死 80）
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf

# 启动 Apache 服务器
apache2-foreground
