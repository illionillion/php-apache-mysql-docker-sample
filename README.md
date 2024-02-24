# PHPで画像を投稿する日記アプリ

## 環境構築

`.env`ファイルに以下を記述

```env
MYSQL_DATABASE=my_db
MYSQL_PORT=3306
ADMIN_PORT=3307
PHP_PORT=9090
```

ターミナルを起動して以下を実行（初回は「`--build`もつける」）

```bash
docker compose up -d --build
```

`http://localhost:9090`でWebサーバーにアクセス

`http://localhost:3307`でphpMyAdminにアクセス


- サーバー：`db`
- ユーザー名：`root`
- パスワード：`password`

でログインできる。

起動直後はログインできないので、少し待つ。

コンテナを終了する際は以下を実行

```bash
docker compose down
```