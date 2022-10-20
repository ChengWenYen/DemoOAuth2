## 項目概述

* 名稱： Demo OAuth 2.0 Site

## 功能如下

- 整合 LINE LOGIN 用戶認證 —— 登錄、退出；
- 整合 LINE Notify 推送通知訊息

## 運行環境要求

- Nginx 1.8+
- PHP 8.1+
- MariaDB 10.3.13+

## 開發環境部署/安裝

本項目代碼使用PHP 框架 Laravel 9.36 開發。

下文將在假定讀者已經安裝好了 Homestead 的情況下進行說明。如果您還未安裝 Homestead，可以參照 [Homestead 安裝與設置](https://learnku.com/docs/laravel/5.5/homestead#installation-and-setup) 進行安裝配置。

### 基礎安裝

#### 1. 克隆源代碼

Clone `Demo OAuth 2.0 Site` 源代碼到本地：

    > git clone https://github.com/ChengWenYen/DemoOAuth2.git

#### 2. 配置本地的 Homestead 環境

1). 運行以下命令編輯 Homestead.yaml 文件：

```shell
homestead edit
```

2). 加入對應修改，如下所示：

```
folders:
    - map: ~/my-path/DemoOAuth2/ # 你本地的項目目錄地址
      to: /home/vagrant/DemoOAuth2

sites:
    - map: DemoOAuth2.test
      to: /home/vagrant/DemoOAuth2/public

databases:
    - demooauth2
```

3). 應用修改

修改完成後保存，然後執行以下命令應用配置信息修改：

```shell
homestead provision
```

隨後請運行 `homestead reload` 進行重啟。

#### 3. 安裝擴展包依賴

composer install

#### 4. 生成配置文件

```
cp .env.example .env
```

你可以根據情況修改 `.env` 文件裡的內容，如數據庫連接、緩存、郵件設置等：

```
APP_URL=http://DemoOAuth2.test
...
DB_HOST=localhost
DB_DATABASE=demooauth2
DB_USERNAME=homestead
DB_PASSWORD=secret

LINE_CLIENT_ID=
LINE_CLIENT_SECRET=

LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
```

#### 5. 生成數據表及生成測試數據

在 Homestead 的網站根目錄下運行以下命令

```shell
$ php artisan migrate --seed
```

初始的用戶角色權限已使用數據遷移生成。

#### 7. 生成秘鑰

```shell
php artisan key:generate
```

#### 8. 配置 hosts 文件

    echo "192.168.10.10 DemoOAuth2.test" | sudo tee -a /etc/hosts

### 鏈接入口

* Admin Dashboard 首頁地址：http://DemoOAuth2.test/admin/login

管理員賬號密碼如下:

```
username: admin@admin.com
password: password
```

至此, 安裝完成。
