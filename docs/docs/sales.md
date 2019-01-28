In order to get information about the sale that we did we need to create a 
simple REST request:

```rest
GET /api/sales
```
Here is an example:

```json
[
  {
    "id": 1,
    "payme_sale_code": 125,
    "product": "Pizza with pineapple",
    "price": 2500,
    "currency": "ILS",
    "payment_link": "URL",
    "created_at": "2019-01-28 22:23:10",
    "updated_at": "2019-01-28 22:23:10"
  } 
]
```

* `id` - The ID of the entry in the DB
* `payme_sale_code` - The sale number we got from payme
* `product` - The name of the product
* `price` - The price - in cents
* `currency` - The currency which used in the transaction
* `payment_link` - An address to pay using payme service
* `created_at` - Date when the entry created
* `updated_at` - Date when the entry last updated
