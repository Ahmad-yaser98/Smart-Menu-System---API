# ملخص نظام Backend (Smart Menu System)

هذا الملف يحتوي على ملخص شامل لهيكلة النظام (Models)، مسارات الـ API (Routes)، المصادقة (Authentication)، العلاقات (Relationships)، وصلاحيات المستخدمين (Roles).

---

## 1. قائمة النماذج (Models) وحقولها (Fields)

### `User` (المستخدم)
- `id`
- `name` (الاسم)
- `email` (البريد الإلكتروني)
- `email_verified_at`
- `password` (كلمة المرور)
- `role` (الصلاحية)
- `remember_token`
- `created_at`, `updated_at`, `deleted_at` (متوافق مع الحذف الناعم - Soft Deletes)

### `Category` (صنف المنيو)
- `id`
- `name` (اسم الصنف)
- `description` (الوصف)
- `created_at`, `updated_at`

### `MenuItem` (عنصر المنيو / الوجبة)
- `id`
- `category_id` (رقم الصنف)
- `name` (الاسم)
- `price` (السعر)
- `is_available` (متاح أم لا)
- `description` (الوصف)
- `created_at`, `updated_at`, `deleted_at`

### `Table` (الطاولة)
- `id`
- `table_number` (رقم الطاولة)
- `capacity` (السعة الاستيعابية)
- `status` (حالة الطاولة)
- `waiter_id` (رقم الويتر المسؤول)
- `created_at`, `updated_at`

### `Order` (الطلب)
- `id`
- `table_id` (رقم الطاولة)
- `waiter_id` (رقم الويتر)
- `status` (حالة الطلب)
- `total_amount` (القيمة الإجمالية)
- `special_requests` (طلبات خاصة)
- `created_at`, `updated_at`

### `OrderItem` (عناصر الطلب)
- `id`
- `order_id` (رقم الطلب)
- `menu_item_id` (رقم الوجبة)
- `quantity` (الكمية)
- `item_price` (סعر الوحدة)
- `item_status` (حالة العنصر - مثال: قيد التحضير، جاهز)
- `created_at`, `updated_at`

### `Invoice` (الفاتورة)
- `id`
- `order_id` (رقم الطلب)
- `cashier_id` (رقم الكاشير)
- `total_amount` (المبلغ الإجمالي)
- `payment_method` (طريقة الدفع)
- `payment_status` (حالة الدفع)
- `created_at`, `updated_at`

---

## 2. قائمة مسارات الـ API (API Routes)

جميع الـ Routes مدرجة في `routes/api.php`:

### مسارات عامة (بدون مصادقة)
- `POST /login` ➔ `AuthController::login`

### مسارات تتطلب تسجيل دخول (Auth)
- `POST /logout` ➔ `AuthController::logout`
- `PUT /profile/update` ➔ `AuthController::updateProfile`
- `GET /menu` ➔ `MenuController::index`
- `GET /categories` ➔ `CategoryController::index`
- `GET /categories/{category}` ➔ `CategoryController::show`
- `GET /menu-items` ➔ `MenuItemController::index`
- `GET /menu-items/{menuItem}` ➔ `MenuItemController::show`

### مسارات المدير (`role:admin`)
- `GET, POST, PUT, DELETE /users` ➔ `UserController` (apiResource)
- `POST, PUT, DELETE /categories` ➔ `CategoryController` (apiResource - باستثناء الـ index و show)
- `POST, PUT, DELETE /menu-items` ➔ `MenuItemController` (apiResource - باستثناء الـ index و show)
- `GET, POST, PUT, DELETE /tables` ➔ `TableController` (apiResource)
- `GET /reports/financial` ➔ `ReportController::financial`

### مسارات الويتر (`role:waiter`)
- `GET /tables` ➔ `TableController::index`
- `PUT /tables/{id}/status` ➔ `TableController::updateStatus`
- `PUT /tables/{id}/assign` ➔ `TableController::assignWaiter`
- `PATCH /orders/{id}/serve` ➔ `OrderController::serveOrder`
- `GET /orders/active` ➔ `OrderController::waiterOrders`
- `POST /orders` ➔ `OrderController::store`
- `POST /orders/{id}/items` ➔ `OrderController::addItem`
- `DELETE /orders/{order_id}/items/{item_id}` ➔ `OrderController::removeItem`

### مسارات المطبخ (`role:kitchen`)
- `GET /kitchen/orders` ➔ `KitchenController::activeOrders`
- `PUT /kitchen/orders/{id}/status` ➔ `KitchenController::updateStatus`

### مسارات الكاشير (`role:cashier`)
- `GET /cashier/orders` ➔ `OrderController::unpaidOrders`
- `GET /invoices/{order_id}` ➔ `InvoiceController::generateInvoice`
- `POST /invoices/{order_id}/pay` ➔ `InvoiceController::processPayment`

---

## 3. نوع المصادقة المستخدم (Authentication)
النظام يعتمد على **Laravel Sanctum** كنظام للمصادقة عبر الـ API Tokens. حيث يتم تمرير التوكن في الترويسة واستخدام الـ Middleware الخاص بسانكتوم (`auth:sanctum`) لحماية المسارات.

---

## 4. العلاقات المهمة بين النماذج (Relationships)

- **User**:
  - يملك الكثير من الطلبات كـ ويتر (`orders` ➔ `hasMany: Order`).
  - يملك الكثير من الفواتير كـ كاشير (`invoices` ➔ `hasMany: Invoice`).
- **Table**:
  - تملك الكثير من الطلبات (`orders` ➔ `hasMany: Order`).
  - يرتبط بها ويتر واحد (`waiter` ➔ `belongsTo: User`).
- **Category**:
  - يملك الكثير من الوجبات (`menuItems` ➔ `hasMany: MenuItem`).
- **MenuItem**:
  - ينتمي إلى قسم/توصيف محدد (`category` ➔ `belongsTo: Category`).
  - يملك الكثير من عناصر الطلب (`orderItems` ➔ `hasMany: OrderItem`).
- **Order**:
  - ينتمي إلى طاولة (`table` ➔ `belongsTo: Table`).
  - ينتمي إلى ويتر (`waiter` ➔ `belongsTo: User`).
  - يملك الكثير من العناصر (`items` ➔ `hasMany: OrderItem`).
  - يملك فاتورة واحدة (`invoice` ➔ `hasOne: Invoice`).
- **OrderItem**:
  - ينتمي إلى طلب (`order` ➔ `belongsTo: Order`).
  - ينتمي إلى وجبة (`menuItem` ➔ `belongsTo: MenuItem`).
- **Invoice**:
  - ينتمي إلى طلب (`order` ➔ `belongsTo: Order`).
  - ينتمي إلى كاشير (`cashier` ➔ `belongsTo: User`).

---

## 5. صلاحيات المستخدمين (Roles)
حسب الـ Middleware وحقل الـ Role في المستخدم، توجد أربعة أدوار رئيسية مطبقة في النظام:
1. **admin (مدير):** لكامل الصلاحيات، إدارة الموظفين، إدارة المنيو (أقسام ووجبات)، الطاولات، التقارير.
2. **waiter (ويتر/مُقدّم طعام):** استعراض وتحديث الطاولات، وإنشاء وتعديل الطلبات للعملاء.
3. **kitchen (المطبخ / الشيف):** استعراض الطلبات النشطة، وتحديث حالة الطلبات (قيد التحضير، جاهز، الخ).
4. **cashier (الكاشير):** استعراض الطلبات غير المدفوعة، إنشاء وطباعة الفواتير، ومعالجة عمليات الدفع.
