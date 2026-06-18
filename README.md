# TechMart - Website thương mại điện tử

TechMart là project website thương mại điện tử được xây dựng bằng Laravel, phục vụ môn Phân tích thiết kế phần mềm. Hệ thống mô phỏng quy trình bán hàng trực tuyến cho cửa hàng công nghệ, bao gồm quản lý sản phẩm, danh mục, giỏ hàng, đặt hàng, thanh toán, quản trị đơn hàng và giao hàng.

## Thông tin project

- Tên repository: `software_project`
- Tên ứng dụng: `TechMart`
- Framework backend: Laravel 10
- Giao diện: Blade, Tailwind CSS, Bootstrap admin template
- Cơ sở dữ liệu: MySQL
- Công cụ build frontend: Vite
- Xác thực: Laravel Breeze
- Thanh toán tích hợp/mô phỏng: COD, chuyển khoản ngân hàng, QR payment, MoMo, VNPay, Stripe

## Thành viên / nhóm

Project được thực hiện bởi nhóm sinh viên cho môn Phân tích thiết kế phần mềm.

## Chức năng chính

### Khách hàng

- Đăng ký, đăng nhập và đăng xuất tài khoản.
- Xem danh sách sản phẩm.
- Xem chi tiết sản phẩm.
- Tìm kiếm sản phẩm.
- Lọc sản phẩm theo danh mục.
- Thêm sản phẩm vào giỏ hàng.
- Cập nhật số lượng sản phẩm trong giỏ hàng.
- Xóa sản phẩm khỏi giỏ hàng.
- Đặt hàng và nhập thông tin giao hàng.
- Theo dõi danh sách đơn hàng cá nhân.
- Xem chi tiết đơn hàng.
- Cập nhật thông tin hồ sơ cá nhân.

### Quản trị viên

- Truy cập dashboard quản trị.
- Quản lý danh mục sản phẩm.
- Quản lý sản phẩm.
- Quản lý người dùng.
- Quản lý đơn hàng.
- Cập nhật trạng thái đơn hàng.
- Phân công shipper cho đơn hàng.
- Xem thống kê doanh thu.
- Xuất báo cáo doanh thu.

### Shipper

- Xem danh sách đơn hàng được phân công.
- Xem chi tiết đơn giao hàng.
- Cập nhật trạng thái giao hàng.

### Thanh toán

Hệ thống hỗ trợ nhiều phương thức thanh toán:

- Thanh toán khi nhận hàng (COD).
- Chuyển khoản ngân hàng.
- Thanh toán bằng mã QR.
- MoMo.
- VNPay sandbox.
- Stripe checkout.

## Công nghệ sử dụng

- PHP `^8.1`
- Laravel `^10.10`
- Laravel Sanctum
- Laravel Breeze
- MySQL
- Composer
- Node.js / npm
- Vite
- Tailwind CSS
- Alpine.js
- Axios

## Cấu trúc thư mục quan trọng

```text
app/
  Http/Controllers/        Controller xử lý nghiệp vụ
  Models/                  Model Eloquent
  Services/                Service xử lý nghiệp vụ riêng
config/                    Cấu hình Laravel
database/
  migrations/              File tạo/cập nhật bảng dữ liệu
  seeders/                 Dữ liệu mẫu
public/                    Entry point và asset public
resources/
  css/                     CSS frontend
  js/                      JavaScript frontend
  views/                   Giao diện Blade
routes/
  web.php                  Route web chính
document/                  Tài liệu báo cáo project
```

## Yêu cầu môi trường

Trước khi chạy project, cần cài đặt:

- PHP 8.1 trở lên
- Composer
- Node.js và npm
- MySQL hoặc MariaDB
- Git

## Hướng dẫn cài đặt

### 1. Clone repository

```bash
git clone https://github.com/lamchamhuy/software_project.git
cd software_project
```

### 2. Cài đặt package PHP

```bash
composer install
```

### 3. Cài đặt package frontend

```bash
npm install
```

### 4. Tạo file môi trường

```bash
cp .env.example .env
```

Trên Windows PowerShell có thể dùng:

```powershell
Copy-Item .env.example .env
```

### 5. Tạo application key

```bash
php artisan key:generate
```

### 6. Cấu hình database

Tạo database MySQL tên `techmart`, sau đó kiểm tra lại các biến trong file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techmart
DB_USERNAME=root
DB_PASSWORD=
```

Nếu máy bạn dùng tài khoản hoặc mật khẩu MySQL khác, hãy sửa lại `DB_USERNAME` và `DB_PASSWORD`.

### 7. Chạy migration và seed dữ liệu mẫu

```bash
php artisan migrate --seed
```

### 8. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### 9. Build hoặc chạy frontend

Khi phát triển:

```bash
npm run dev
```

Khi build production:

```bash
npm run build
```

### 10. Chạy server Laravel

```bash
php artisan serve
```

Sau đó truy cập:

```text
http://127.0.0.1:8000
```

## Tài khoản mẫu

Sau khi chạy seed, có thể đăng nhập bằng các tài khoản sau:

### Admin

```text
Email: admin@techmart.vn
Mật khẩu: admin123
```

### Shipper

```text
Email: shipper@techmart.vn
Mật khẩu: shipper123
```

### Khách hàng

```text
Email: nguyenvanan@gmail.com
Mật khẩu: password
```

```text
Email: tranthibinh@gmail.com
Mật khẩu: password
```

## Một số đường dẫn chính

```text
/                         Trang chủ
/products                 Danh sách sản phẩm
/search                   Tìm kiếm sản phẩm
/cart                     Giỏ hàng
/checkout                 Thanh toán
/orders                   Đơn hàng của khách hàng
/admin                    Trang quản trị
/admin/products           Quản lý sản phẩm
/admin/categories         Quản lý danh mục
/admin/orders             Quản lý đơn hàng
/admin/users              Quản lý người dùng
/admin/revenue            Thống kê doanh thu
/shipper                  Trang shipper
```

## Cấu hình thanh toán

Project có sẵn cấu hình mẫu trong `.env.example` cho VNPay sandbox và QR payment.

Ví dụ:

```env
VNP_TMNCODE=LD60ZQ00
VNP_HASHSECRET=A0OACECW3YF2QKSETVEIX2V72JU1H5YX
VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNP_RETURNURL=http://127.0.0.1:8000/vnpay-return

QR_BANK_CODE=VCB
QR_BANK_NAME=Vietcombank
QR_BANK_ACCOUNT_NUMBER=1234567890
QR_BANK_ACCOUNT_NAME="TECHMART COMPANY"
QR_BANK_BRANCH="Ha Noi"
```

Khi triển khai thật, cần thay toàn bộ thông tin sandbox/demo bằng thông tin chính thức và bảo mật khóa thanh toán trong biến môi trường.

## Tài liệu báo cáo

Tài liệu project được đặt trong thư mục:

```text
document/
```

Hiện repository có các file báo cáo:

```text
document/BaoCao_TechMart_SuaBoCuc_XoaTieuDeTrongSoDo_Final (1).docx
document/BaoCao_TechMart_SuaBoCuc_XoaTieuDeTrongSoDo_Final (1).pdf
```

## Lưu ý khi làm việc với Git

Các file và thư mục sau không nên đưa lên GitHub:

- `.env`
- `vendor/`
- `node_modules/`
- `public/storage/`
- File cache/log sinh ra trong quá trình chạy

Các file này đã được cấu hình trong `.gitignore` để tránh commit nhầm.

## Lệnh Git thường dùng

Kiểm tra trạng thái:

```bash
git status
```

Thêm thay đổi:

```bash
git add .
```

Tạo commit:

```bash
git commit -m "Mo ta thay doi"
```

Đẩy lên GitHub:

```bash
git push
```

Lấy code mới nhất từ GitHub:

```bash
git pull
```

## Ghi chú triển khai

Khi deploy lên hosting/server, cần thực hiện các bước cơ bản:

- Cấu hình `.env` cho môi trường production.
- Tắt debug bằng `APP_DEBUG=false`.
- Cài dependency bằng `composer install --no-dev --optimize-autoloader`.
- Chạy `npm run build`.
- Chạy migration nếu cần.
- Cache config, route và view.
- Trỏ document root của web server vào thư mục `public/`.

## License

Project phục vụ mục đích học tập.
