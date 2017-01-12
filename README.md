# featured-product
A Wordpress plugin to rotate featured products / events.  Supports multiple, store-specific links and prices per featured item.
The idea is that you can have the same product listed for different prices at different stores (e.g. Etsy, Craftsy, Ebay) and
wish to give the customer a choice of stores to buy from.

## Installation:
FIXME

## Data:
-  Reads input data from CSV file in `data` directory.
-  Expects comma-separated values in the following format:
  -  `image-url,store-link-1,price1,store-link2,price2,store-link-3,price3`
  -  **Note:**  Must supply matching pairs of store links and prices
  -  If price is irrelevant in your context, it may be omitted.  Please use the following format:
    -  `image-url,link-1,,link-2,,link-3,` <-- Note the trailing comma
