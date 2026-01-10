# Order Flow App Backend（Laravel API）

受注ミス防止を目的とした「注文管理」ポートフォリオのバックエンド（Laravel API）です。

- Frontend: https://github.com/keraneko/order-flow-app-frontend
- Backend:  https://github.com/keraneko/order-flow-app-backend

## What this API does
- 商品一覧取得（GET /api/products）
- 店舗一覧取得（GET /api/stores）
- 注文作成（POST /api/orders）

## Tech Stack
- Laravel [12]（API）
- PHP 8.2（Docker / Laravel Sail）
- MySQL


## Setup（ローカル起動 / Sail）
```bash
cp .env.example .env
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
