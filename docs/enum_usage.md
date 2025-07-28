# Enum Usage Guide

This guide explains how to use the type-safe enum system implemented in the CargoTransport application.

## Available Enums

### 1. Role Enum

Defines user roles in the system:

```php
use App\Enums\Role;

// Available values
Role::CUSTOMER        // 'customer'
Role::ADMIN          // 'admin'
Role::DRIVER         // 'driver'
Role::DELIVERY_PERSON // 'delivery_person'
```

**Helper Methods:**

```php
// Get all values
Role::values(); // ['customer', 'admin', 'driver', 'delivery_person']

// Get all names
Role::names(); // ['CUSTOMER', 'ADMIN', 'DRIVER', 'DELIVERY_PERSON']

// Get options for forms
Role::options(); // ['customer' => 'CUSTOMER', 'admin' => 'ADMIN', ...]

// Validate value
Role::isValid('admin'); // true
Role::isValid('invalid'); // false
```

### 2. Status Enum

Defines cargo/order statuses:

```php
use App\Enums\Status;

// Available values
Status::DRAFT                    // 'draft'
Status::PENDING_ADMIN_APPROVAL   // 'pending_admin_approval'
Status::REJECTED_BY_ADMIN        // 'rejected_by_admin'
Status::PRICED_BY_ADMIN          // 'priced_by_admin'
Status::PENDING_CUSTOMER_APPROVAL // 'pending_customer_approval'
Status::REJECTED_BY_CUSTOMER     // 'rejected_by_customer'
Status::PENDING_PAYMENT          // 'pending_payment'
Status::PAID                     // 'paid'
Status::IN_TRANSIT               // 'in_transit'
Status::DELIVERED                // 'delivered'
```

**Helper Methods:**

```php
// Get all values
Status::values(); // ['draft', 'pending_admin_approval', ...]

// Get all names
Status::names(); // ['DRAFT', 'PENDING_ADMIN_APPROVAL', ...]

// Get options for forms
Status::options(); // ['draft' => 'DRAFT', 'pending_admin_approval' => 'PENDING_ADMIN_APPROVAL', ...]

// Validate value
Status::isValid('paid'); // true
Status::isValid('invalid'); // false
```

### 3. PaymentMethod Enum

Defines available payment methods:

```php
use App\Enums\PaymentMethod;

// Available values
PaymentMethod::SYRIATEL_CASH // 'Syriatel_Cash'
PaymentMethod::MTN_CASH      // 'MTN_Cash'
```

**Helper Methods:**

```php
// Get all values
PaymentMethod::values(); // ['Syriatel_Cash', 'MTN_Cash']

// Get all names
PaymentMethod::names(); // ['SYRIATEL_CASH', 'MTN_CASH']

// Get options for forms
PaymentMethod::options(); // ['Syriatel_Cash' => 'SYRIATEL_CASH', 'MTN_Cash' => 'MTN_CASH']

// Validate value
PaymentMethod::isValid('Syriatel_Cash'); // true
PaymentMethod::isValid('invalid'); // false
```

## Usage in Models

### Using BaseModel

Extend from `BaseModel` to get enum functionality:

```php
use App\Models\BaseModel;
use App\Enums\Status;
use App\Enums\Role;

class Order extends BaseModel
{
    protected $fillable = [
        'status',
        'customer_id',
        'amount',
        // ...
    ];

    protected $casts = [
        'status' => Status::class,
        'amount' => 'decimal:2',
    ];
}

class User extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'role',
        // ...
    ];

    protected $casts = [
        'role' => Role::class,
        'email_verified_at' => 'datetime',
    ];
}
```

### Model Usage Examples

```php
// Create with enum
$order = Order::create([
    'status' => Status::DRAFT,
    'amount' => 100.00,
]);

// Access enum value
echo $order->status->value; // 'draft'

// Query with enums
$draftOrders = Order::where('status', Status::DRAFT)->get();
$paidOrders = Order::where('status', Status::PAID->value)->get();
$multipleStatuses = Order::whereIn('status', [
    Status::PAID->value,
    Status::IN_TRANSIT->value
])->get();

// Using enum scopes from HasEnums trait
$orders = Order::whereEnum('status', Status::DRAFT)->get();
$users = User::whereEnumIn('role', [Role::ADMIN, Role::DRIVER])->get();
```

## Usage in Requests

### Using EnumRule

```php
use App\Http\Requests\BaseRequest;
use App\Rules\EnumRule;
use App\Enums\Status;
use App\Enums\Role;

class CreateOrderRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            // Using EnumRule (recommended)
            'status' => [EnumRule::required(Status::class)],
            'payment_method' => [EnumRule::nullable(PaymentMethod::class)],

            // Traditional validation
            'role' => ['required', 'string', 'in:' . implode(',', Role::values())],

            // Other fields
            'amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function getValidatedEnums(): array
    {
        $validated = $this->validated();

        // Cast to enum instances
        if (isset($validated['status'])) {
            $validated['status'] = Status::from($validated['status']);
        }

        return $validated;
    }
}
```

### Example Request Usage

```php
class OrderController extends BaseController
{
    public function store(CreateOrderRequest $request)
    {
        $data = $request->getValidatedEnums();

        // $data['status'] is now a Status enum instance
        $order = Order::create($data);

        return $this->successResponse($order, 'Order created successfully');
    }
}
```

## Usage in Controllers

```php
use App\Http\Controllers\BaseController;
use App\Enums\Status;
use App\Models\Order;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by status
        if ($request->has('status')) {
            $status = Status::from($request->status);
            $query->where('status', $status);
        }

        // Filter by multiple statuses
        if ($request->has('statuses')) {
            $statusValues = array_map(
                fn($s) => Status::from($s)->value,
                $request->statuses
            );
            $query->whereIn('status', $statusValues);
        }

        $orders = $query->paginate();

        return $this->successResponse($orders);
    }

    public function updateStatus(Order $order, Request $request)
    {
        $newStatus = Status::from($request->status);

        $order->status = $newStatus;
        $order->save();

        return $this->successResponse($order, 'Status updated successfully');
    }
}
```

## Database Migrations

When creating migrations, use string columns for enum fields:

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('status')->default('draft');
    $table->string('payment_method')->nullable();
    $table->timestamps();

    // Add indexes for frequently queried enum fields
    $table->index('status');
});

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('role')->default('customer');
    $table->timestamps();

    $table->index('role');
});
```

## API Responses

Enums are automatically serialized in API responses:

```json
{
    "data": {
        "id": 1,
        "status": "pending_admin_approval",
        "amount": "100.00",
        "created_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

## Best Practices

1. **Always use enum instances in business logic:**

    ```php
    // Good
    if ($order->status === Status::DELIVERED) {
        // ...
    }

    // Avoid
    if ($order->status === 'delivered') {
        // ...
    }
    ```

2. **Use enum validation in requests:**
   ```php
   // Preferred
   'status' => [EnumRule::required(Status::class)],
   
   // Alternative
   'status' => ['required', 'string', 'in:' . implode(',', Status::values())],
   ```

3. **Use enum helper methods for validation:**
   ```php
   // Validate enum values
   if (Status::isValid($value)) {
       $status = Status::from($value);
   }
   
   // Get enum options for forms
   $statusOptions = Status::options();
   ```

4. **Use enum scopes for queries:**
   ```php
   // Use enum scopes from HasEnums trait
   Order::whereEnum('status', Status::DRAFT)->get();
   Order::whereEnumIn('status', [Status::PAID, Status::IN_TRANSIT])->get();
   ```

5. **Handle enum casting in requests:**

    ```php
    public function getValidatedEnums(): array
    {
        $validated = $this->validated();

        foreach (['status', 'role', 'payment_method'] as $field) {
            if (isset($validated[$field])) {
                $enumClass = $this->getEnumClass($field);
                $validated[$field] = $enumClass::from($validated[$field]);
            }
        }

        return $validated;
    }
    ```

This enum system provides type safety, better IDE support, and cleaner code while maintaining database compatibility with string values.
