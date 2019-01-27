A clearing operation is when you charge money from a credit card.


```rest
POST /api/pay

{
    "sale_price": "2500",
    "currency": "ILS",
    "product_name": "Pizza"
}
```

* `sale_price` - The price in cents
* `currency` - The currency - ILS, USD, EUR etc, etc,
* `product_name` - The name of the product.

If everything went OK you'll get a 200 status code and the response:

```json
{
  "message": "The clearing process went OK"
}
```

If not, you'll get something 400 status code and en error like:
```json
{
  "message": "Something went wrong during the clearing. Please check logs"
}
```
