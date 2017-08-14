

### 克隆源码到本地
> git clone https://github.com/maidi-yang/laravel

### 进入项目目录
> cd laravel

### 拷贝`.env`文件
一些 `secret key` 改成自己服务的`key`即可
> cp .env.example .env

### 下载相关的依赖包
下载`laravel`相关依赖的包
> composer install

### 创建密钥
php artisan key:generate 

### 数据库迁移
> php artisan migrate

