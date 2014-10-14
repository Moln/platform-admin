#Zend Framework 2 管理后台

Zend Framework 2 开发管理后台, 开源项目
前端使用 kendoUI (Javascript ui framework)

Admin 为管理模块
Product 写的Demo.

##安装说明

前提软件:
- [Composer](https://getcomposer.org/).
- Zf tool 可选依赖工具

步骤:

1. 下载源码解压, 或者使用`git clone`
2. 进入代码目录输入 `composer install`, 会进行下载 zf2 和 gzfextra
3. 将 `docs/admin.sql` 导入的数据库, 数据库名 `platform-admin`, utf8编码.
  也可使用其它库名, `config/autoload/global.php` 修改配置
4. (可忽略此步骤) 按照ZF2 官方文档配置虚拟主机
```
<VirtualHost *:80>
     ServerName zf2-tutorial.localhost
     DocumentRoot /path/to/zf2-tutorial/public
     SetEnv APPLICATION_ENV "development"
     <Directory /path/to/zf2-tutorial/public>
         DirectoryIndex index.php
         AllowOverride All
         Order allow,deny
         Allow from all
     </Directory>
 </VirtualHost>
```
5. 浏览器进入 `public` 目录, 默认账号密码都是 `admin`

##LICENSE
MIT




